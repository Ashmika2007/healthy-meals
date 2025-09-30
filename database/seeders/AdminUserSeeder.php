<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // ✅ add this
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Password123'),
            ]
        );
    }
}
