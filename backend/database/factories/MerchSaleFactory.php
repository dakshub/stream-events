<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MerchSale>
 */
class MerchSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item' => fake()->randomElement(['T-Shirt', 'Mug', 'Hoodie', 'Hat', 'Sticker', 'Poster']),
            'quantity' => fake()->numberBetween(1, 10),
            'price' => fn (array $attributes) => match ($attributes['item']) {
                'T-Shirt' => 20,
                'Mug' => 10,
                'Hoodie' => 30,
                'Hat' => 15,
                'Sticker' => 5,
                'Poster' => 10,
            },
            'total' => fn (array $attributes) => $attributes['price'] * $attributes['quantity'],
            'currency' => 'USD',
            'buyer_name' => fake()->name(),
            'user_id' => UserFactory::new(),
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'updated_at' => fn (array $attributes) => $attributes['created_at'],
        ];
    }
}
