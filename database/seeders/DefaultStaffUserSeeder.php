<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import the Hash facade for password hashing

class DefaultStaffUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create([
            'name' => 'superadmin', // Default admin name
            'email' => 'admin@gmail.com', // Default admin email
            'password' => Hash::make('admin'), // Default admin password (hashed!) - CHANGE THIS!
            // You can add other fields if needed, like 'email_verified_at' => now(), etc.
        ]);
    }
}