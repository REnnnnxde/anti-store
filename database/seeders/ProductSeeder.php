<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kategori
        $categories = Category::all();

        if ($categories->count() < 4) {
            $this->command->error('Kategori kurang dari 4! Jalankan CategorySeeder dulu.');
            return;
        }

        $products = [
            [
                'category' => 'Women',
                'name' => 'Casual Linen Shirt',
                'description' => 'Kemeja linen casual dengan bahan premium yang nyaman dipakai sehari-hari. Cocok untuk gaya santai maupun semi formal.',
                'price' => 450000,
                'stock' => 25,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'category' => 'Men',
                'name' => 'Classic Denim Jacket',
                'description' => 'Jaket denim klasik dengan cutting modern. Bahan tebal dan tahan lama, cocok untuk gaya streetwear.',
                'price' => 650000,
                'stock' => 18,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'category' => 'Accessories',
                'name' => 'Leather Crossbody Bag',
                'description' => 'Tas selempang kulit asli dengan desain minimalis. Ukuran compact untuk daily use.',
                'price' => 320000,
                'stock' => 30,
                'is_featured' => false,
                'status' => 'active',
            ],
            [
                'category' => 'Footwear',
                'name' => 'Classic White Sneakers',
                'description' => 'Sepatu sneakers putih klasik dengan sol tebal. Nyaman dipakai seharian dan cocok dengan berbagai gaya.',
                'price' => 550000,
                'stock' => 12,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'category' => 'Women',
                'name' => 'Oversized Blazer',
                'description' => 'Blazer oversized dengan bahan wool blend. Memberikan kesan chic dan sophisticated.',
                'price' => 750000,
                'stock' => 8,
                'is_featured' => false,
                'status' => 'active',
            ],
        ];

        foreach ($products as $data) {
            $category = Category::where('name', $data['category'])->first();

            if (!$category) {
                $this->command->warn('Kategori "' . $data['category'] . '" tidak ditemukan!');
                continue;
            }

            Product::create([
                'category_id' => $category->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => $data['stock'],
                'image' => null,
                'is_featured' => $data['is_featured'],
                'status' => $data['status'],
            ]);

            $this->command->info('✅ Produk "' . $data['name'] . '" berhasil dibuat!');
        }

        $this->command->info('🎉 5 Produk berhasil ditambahkan!');
    }
}
