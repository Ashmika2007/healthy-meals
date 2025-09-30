<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(['name' => 'Salads'], ['image' => 'salads.jpg']);
        Category::updateOrCreate(['name' => 'Smoothies'], ['image' => 'smoothies.jpg']);
        Category::updateOrCreate(['name' => 'Snacks'], ['image' => 'snacks.jpg']);
    }
}
