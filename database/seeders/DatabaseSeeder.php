<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Jalankan dengan: php artisan db:seed
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
