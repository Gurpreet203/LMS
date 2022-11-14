<?php

namespace Database\Seeders;


use App\Models\Category;

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Science',
            'slug' => 'science',
            'created_by' => 1
        ]);
        Category::create([
            'name' => 'Commerce',
            'slug' => 'commerce',
            'created_by' => 1
        ]);
        Category::create([
            'name' => 'Arts',
            'slug' => 'arts',
            'created_by' => 1
        ]);
        Category::create([
            'name' => 'Vocational',
            'slug' => 'vocational',
            'created_by' => 1
        ]);
    }
}
