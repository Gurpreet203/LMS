<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'role_id' => 1,
            'slug' => 'admin',
            'email' => 'admin@admin.com',
            'created_by' => 1,
            'gender' => 'male',
            'phone' => 9915607741,
            'password' => Hash::make('admin123'),
            'status' => '1',
            'email_status' => '1'
            
        ]);
        User::create([
            'first_name' => 'Sub',
            'last_name' => 'Admin',
            'role_id' => 2,
            'slug' => 'sub-admin',
            'email' => 'subadmin@gmail.com',
            'created_by' => 1,
            'gender' => 'male',
            'phone' => 12345678,
            'password' => Hash::make('12345678'),
            
        ]);
        User::create([
            'first_name' => 'Employee',
            'last_name' => 'Sharma',
            'role_id' => 3,
            'slug' => 'employee-sharma',
            'email' => 'employee@gmail.com',
            'created_by' => 1,
            'gender' => 'male',
            'phone' => 12345678,
            'password' => Hash::make('12345678'),
            
        ]);
        User::create([
            'first_name' => 'Gurpreet',
            'last_name' => 'Singh',
            'role_id' => 4,
            'slug' => 'gurpreet-singh',
            'email' => 'test@gmail.com',
            'created_by' => 1,
            'gender' => 'male',
            'phone' => 12345678,
            'password' => Hash::make('12345678'),
            
        ]);
    }
}
