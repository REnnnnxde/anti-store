<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Filter
        $period = $request->get('period', 'this_month');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $status = $request->get('status');
        $categoryId = $request->get('category_id');

        // Query dasar
        $ordersQuery = Order::query();

        // Filter tanggal
        if ($startDate && $endDate) {
            $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($period === 'today') {
            $ordersQuery->whereDate('created_at', today());
        } elseif ($period === 'this_week') {
            $ordersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period === 'this_month') {
            $ordersQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($period === 'this_year') {
            $ordersQuery->whereYear('created_at', now()->year);
        } elseif ($period === 'last_month') {
            $ordersQuery->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year);
        }

        // Filter status
        if ($status) {
            $ordersQuery->where('status', $status);
        }

        // Data Orders
        $orders = $ordersQuery->with('user')->latest()->get();

        // Statistik
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_amount');
        $averageOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // PERBAIKAN: distinct untuk Collection pakai unique()
        $totalCustomers = $orders->unique('user_id')->count();

        // Statistik per status
        $statusStats = [
            'pending' => $orders->where('status', 'pending')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'shipped' => $orders->where('status', 'shipped')->count(),
            'delivered' => $orders->where('status', 'delivered')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];

        // Rekap per hari (7 hari terakhir) - PAKAI QUERY BUILDER BUKAN COLLECTION
        $dailyStats = Order::whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Produk terlaris
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', 'products.image', DB::raw('SUM(order_items.quantity) as total_sold'), DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Kategori terlaris
        $topCategories = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Data untuk grafik
        $chartLabels = $dailyStats->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        })->toArray();

        $chartRevenue = $dailyStats->pluck('revenue')->toArray();
        $chartOrders = $dailyStats->pluck('total')->toArray();

        // Kategori untuk filter
        $categories = Category::all();

        return view('admin.reports.index', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'averageOrder',
            'totalCustomers',
            'statusStats',
            'dailyStats',
            'topProducts',
            'topCategories',
            'chartLabels',
            'chartRevenue',
            'chartOrders',
            'categories',
            'period',
            'startDate',
            'endDate',
            'status',
            'categoryId'
        ));
    }

    public function export(Request $request)
    {
        $orders = Order::with('user')->latest()->get();

        $filename = 'laporan_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        fputcsv($handle, ['No. Order', 'Pelanggan', 'Total', 'Status', 'Pembayaran', 'Tanggal']);

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->order_number,
                $order->user->name ?? 'Unknown',
                $order->total_amount,
                $order->status,
                $order->payment_status,
                $order->created_at->format('d M Y H:i')
            ]);
        }

        fclose($handle);
        exit;
    }
}
