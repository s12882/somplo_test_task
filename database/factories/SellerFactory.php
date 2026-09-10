<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Model default state
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_name' => fake()->unique()->company(),
        ];
    }
}
