<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',  // Replace with your desired admin email
            'password' => Hash::make('password'),  // Replace with your desired admin password
            'email_verified_at' => now(),
        ]);  // Assign the Admin role if you are using roles
    }
}
