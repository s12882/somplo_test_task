<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Model default state
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_name' => ucwords(fake()->unique()->words(2, true)).' '.fake()->numberBetween(1, 20),
            'seller_id' => Seller::factory(),
            'display_size' => fake()->randomFloat(1, 3.5, 7.5),
            'quantity' => fake()->numberBetween(0, 500),
            'cost' => fake()->randomFloat(2, 50, 2000),
        ];
    }
}
