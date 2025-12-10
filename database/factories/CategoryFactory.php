<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
// Jangan lupa import di paling atas: use Illuminate\Support\Str;

public function definition(): array
{
    $name = fake()->unique()->word(); // Menghasilkan 1 kata unik
    return [
        'name' => ucfirst($name),
        'slug' => Str::slug($name),
        'icon' => fake()->imageUrl(64, 64, 'business', true), // Dummy image url
    ];
}
}
