<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(fake()->numberBetween(2, 5), true);

        return [
            'user_id' => User::factory(),
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(8)),
            'description' => fake()->optional(0.78)->paragraph(),
            'price' => fake()->randomFloat(2, 8, 2500),
            'quantity' => fake()->numberBetween(0, 400),
            'status' => fake()->randomElement([
                ProductStatus::Published,
                ProductStatus::Published,
                ProductStatus::Published,
                ProductStatus::Draft,
                ProductStatus::Draft,
                ProductStatus::Archived,
            ]),
        ];
    }
}
