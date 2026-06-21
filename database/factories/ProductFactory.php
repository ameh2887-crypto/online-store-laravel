<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * Catatan: model Product di buku ini tidak memakai trait HasFactory
     * (lihat Bab 14, "Refactoring List Products"). Agar factory tetap bisa
     * dipakai untuk keperluan testing/dummy data tambahan, jalankan dengan:
     *
     *   Product::factory()->count(20)->create();
     *
     * dari sebuah Seeder atau via Tinker, bukan lewat Product::factory()
     * langsung di model (karena HasFactory sengaja tidak dipakai).
     *
     * @return array
     */
    public function definition()
    {
        $images = ['game.png', 'safe.png', 'submarine.png'];

        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(10),
            'image' => $this->faker->randomElement($images),
            'price' => $this->faker->numberBetween(10, 2000),
        ];
    }
}
