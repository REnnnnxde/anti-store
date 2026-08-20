<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->count() < 2) {
            $this->command->error('User tidak cukup!');
            return;
        }

        if ($products->count() < 3) {
            $this->command->error('Produk tidak ada!');
            return;
        }

        // Hapus data lama
        OrderItem::query()->delete();
        Order::query()->delete();

        $orders = [
            [
                'user_id' => 1,
                'order_number' => 'ORD-001',
                'total_amount' => 450000,
                'status' => 'delivered',
                'shipping_address' => 'Jl. Contoh No. 1, Jakarta',
                'payment_method' => 'bank_transfer',
                'payment_status' => 'paid',
                'notes' => null,
                'items' => [
                    ['product_id' => 1, 'quantity' => 2, 'price' => 450000],
                ]
            ],
            [
                'user_id' => 2,
                'order_number' => 'ORD-002',
                'total_amount' => 970000,
                'status' => 'delivered',
                'shipping_address' => 'Jl. Contoh No. 2, Bandung',
                'payment_method' => 'bank_transfer',
                'payment_status' => 'paid',
                'notes' => null,
                'items' => [
                    ['product_id' => 2, 'quantity' => 1, 'price' => 650000],
                    ['product_id' => 3, 'quantity' => 1, 'price' => 320000],
                ]
            ],
            [
                'user_id' => 1,
                'order_number' => 'ORD-003',
                'total_amount' => 1200000,
                'status' => 'delivered',
                'shipping_address' => 'Jl. Contoh No. 1, Jakarta',
                'payment_method' => 'bank_transfer',
                'payment_status' => 'paid',
                'notes' => null,
                'items' => [
                    ['product_id' => 4, 'quantity' => 2, 'price' => 550000],
                    ['product_id' => 1, 'quantity' => 1, 'price' => 100000],
                ]
            ],
            [
                'user_id' => 2,
                'order_number' => 'ORD-004',
                'total_amount' => 750000,
                'status' => 'processing',
                'shipping_address' => 'Jl. Contoh No. 2, Bandung',
                'payment_method' => 'bank_transfer',
                'payment_status' => 'paid',
                'notes' => null,
                'items' => [
                    ['product_id' => 1, 'quantity' => 1, 'price' => 450000],
                    ['product_id' => 3, 'quantity' => 1, 'price' => 300000],
                ]
            ],
        ];

        foreach ($orders as $orderData) {
            $items = $orderData['items'];
            unset($orderData['items']);

            $order = Order::create($orderData);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }

        $this->command->info(' ' . count($orders) . ' Order dengan ' . OrderItem::count() . ' items berhasil dibuat!');
    }
}
