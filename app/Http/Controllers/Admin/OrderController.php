<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diupdate!');
    }

    public function verifyPayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'action' => 'required|in:verify,reject',
            'notes' => 'nullable|string'
        ]);

        if ($request->action === 'verify') {
            $order->update([
                'payment_verification' => 'verified',
                'payment_status' => 'paid',
                'payment_notes' => $request->notes,
                'payment_verified_at' => now(),
                'status' => 'processing'
            ]);
            $message = 'Pembayaran berhasil diverifikasi! Pesanan diproses.';
        } else {
            $order->update([
                'payment_verification' => 'rejected',
                'payment_status' => 'failed',
                'payment_notes' => $request->notes,
            ]);
            $message = 'Pembayaran ditolak!';
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', $message);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_proof) {
            Storage::delete('public/' . $order->payment_proof);
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }
}
