<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles::truncate();

        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            
        ]);
        Role::create([
            'name' => 'Sub Admin',
            'slug' => 'sub-admin',
            
        ]);
        Role::create([
            'name' => 'Employee',
            'slug' => 'employee',
            
        ]);
        Role::create([
            'name' => 'Trainer',
            'slug' => 'trainer',
            
        ]);
    }
}
