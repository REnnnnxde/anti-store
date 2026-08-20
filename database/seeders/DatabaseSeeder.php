<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // HAPUS atau COMMENT dulu user default dari Laravel
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@anti.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'phone' => '08123456789',
            'address' => 'Jl. Admin No. 1, Jakarta',
        ]);

        // User biasa
        User::create([
            'name' => 'User',
            'email' => 'user@anti.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'phone' => '08987654321',
            'address' => 'Jl. User No. 2, Bandung',
        ]);

        // Categories
        $categories = [
            ['name' => 'Women', 'slug' => 'women', 'description' => 'Women fashion collection'],
            ['name' => 'Men', 'slug' => 'men', 'description' => 'Men fashion collection'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Fashion accessories'],
            ['name' => 'Footwear', 'slug' => 'footwear', 'description' => 'Footwear collection'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Products
        $products = [
            [
                'category_id' => 2,
                'name' => 'Casual Wool Jacket',
                'slug' => 'casual-wool-jacket',
                'description' => 'Premium wool jacket for casual wear',
                'price' => 89000,
                'stock' => 25,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'category_id' => 1,
                'name' => 'Oversized Linen Shirt',
                'slug' => 'oversized-linen-shirt',
                'description' => 'Comfortable oversized linen shirt',
                'price' => 59000,
                'stock' => 30,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'category_id' => 4,
                'name' => 'Classic White Sneakers',
                'slug' => 'classic-white-sneakers',
                'description' => 'Timeless white sneakers for everyday',
                'price' => 79000,
                'stock' => 20,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'category_id' => 1,
                'name' => 'Floral Print Maxi Dress',
                'slug' => 'floral-print-maxi-dress',
                'description' => 'Beautiful floral maxi dress',
                'price' => 99000,
                'stock' => 15,
                'is_featured' => true,
                'status' => 'active',
            ],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }

        // Panggil OrderSeeder
        $this->call(OrderSeeder::class);
    }
}
