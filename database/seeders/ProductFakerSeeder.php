<?php

namespace Database\Seeders;

use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class ProductFakerSeeder extends Seeder
{
    /**
     * Seeder opsional untuk membuat banyak produk dummy acak
     * menggunakan ProductFactory (karena model Product tidak
     * memakai trait HasFactory, factory dipanggil langsung di sini).
     *
     * Jalankan terpisah dengan:
     *   php artisan db:seed --class=Database\\Seeders\\ProductFakerSeeder
     *
     * @return void
     */
    public function run()
    {
        ProductFactory::new()->count(20)->create();
    }
}
