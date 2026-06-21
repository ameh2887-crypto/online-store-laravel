<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Mengisi tabel products dengan data dummy yang sama persis
     * dengan yang dipakai pada Bab 11 (sebagai pengganti INSERT SQL manual).
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                "name" => "TV",
                "description" => "Best TV",
                "image" => "game.png",
                "price" => 1000,
            ],
            [
                "name" => "iPhone",
                "description" => "Best iPhone",
                "image" => "safe.png",
                "price" => 999,
            ],
            [
                "name" => "Chromecast",
                "description" => "Best Chromecast",
                "image" => "submarine.png",
                "price" => 30,
            ],
            [
                "name" => "Glasses",
                "description" => "Best Glasses",
                "image" => "game.png",
                "price" => 100,
            ],
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData["name"]);
            $product->setDescription($productData["description"]);
            $product->setImage($productData["image"]);
            $product->setPrice($productData["price"]);
            $product->save();
        }
    }
}
