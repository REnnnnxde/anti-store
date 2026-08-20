<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Women', 'slug' => 'women', 'description' => 'Women fashion collection'],
            ['name' => 'Men', 'slug' => 'men', 'description' => 'Men fashion collection'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Fashion accessories'],
            ['name' => 'Footwear', 'slug' => 'footwear', 'description' => 'Footwear collection'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
