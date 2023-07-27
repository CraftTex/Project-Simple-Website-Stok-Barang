<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->words(3,true),
            'slug' => fake()->slug(),
            'harga_beli' => fake()->randomNumber(5,true),
            'harga_jual' => fake()->randomNumber(5,true),
            'deskripsi' => fake()->paragraphs(1,true)
        ];
    }
}
