<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'last_name' => 'User',
            'dni' => '00000000',
            'phone' => '000000000',
            'email' => 'admin@ebooks.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
