<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Membuat user admin secara otomatis, sebagai pengganti langkah manual
     * via Laravel Tinker pada Bab 22.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@onlinestore.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'balance' => 5000,
            ]
        );
    }
}
