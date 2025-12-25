<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
// Jangan lupa import: use Illuminate\Support\Str;
// Import model: use App\Models\Category;

public function definition(): array
{
    $name = fake()->words(3, true); // Nama produk 3 kata
    return [
        'name' => ucfirst($name),
        'slug' => Str::slug($name),
        'category_id' => Category::factory(), 
        'price' => fake()->numberBetween(50000, 2000000), 
        'stock' => fake()->numberBetween(10, 100),
        'description' => fake()->paragraph(),
        'thumbnail' => fake()->imageUrl(400, 400, 'product', true),
    ];
}
}