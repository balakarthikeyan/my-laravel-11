<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $category = Category::create(['name' => 'Books']);

        Product::factory()->create([
            'name' => 'Television',
            'details' => 'Product CRUD Tutorial',
            'category_id' => $category
        ]);
    }
}
