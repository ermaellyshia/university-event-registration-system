<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Demo Student One',
            'username' => 'student1',
            'email' => 'student1@example.com',
            'password' => Hash::make('Student@123'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Event Administrator',
            'username' => 'admin1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);
    }
}