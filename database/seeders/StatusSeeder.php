<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'name' => 'Public',
            'slug' => 'public'
        ]);
        Status::create([
            'name' => 'Archieved',
            'slug' => 'archieved'
        ]);
        Status::create([
            'name' => 'Draft',
            'slug' => 'draft'
        ]);
    }
}
