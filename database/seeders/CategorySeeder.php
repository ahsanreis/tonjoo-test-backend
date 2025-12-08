<?php

namespace Database\Seeders;

use App\Models\MsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories if any
        MsCategory::truncate();

        // Define the categories to be added
        $categories = ['income', 'expense'];

        foreach ($categories as $category) {
            MsCategory::insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
