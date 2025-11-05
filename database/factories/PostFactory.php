<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 5),
            'title' => fake()->realText(30),
            'body' => fake()->realText(300),
            'status' => fake()->numberBetween(0, 3),
            'age_year' => fake()->numberBetween(0, 15),
            'age_month' => fake()->numberBetween(0, 11),
            'gender' => fake()->numberBetween(0,1),
            'location_id' => fake()->numberBetween(1, 47),
            'breed_id' => fake()->numberBetween(1, 40),
            'pattern_id' => fake()->numberBetween(1, 12),
            'vaccined' => fake()->numberBetween(0,1),
            'neutered' => fake()->numberBetween(0,1),
            'accept_single' => fake()->numberBetween(0,1),
            'accept_senior' => fake()->numberBetween(0,1),
            'accept_location1' => fake()->randomElement(['01', '10', '12', '20', '30', '31', '32']),
            'accept_location2' => fake()->randomElement(['01', '10', '12', '20', '30', '31', '32']),
            'accept_location3' => fake()->randomElement(['01', '10', '12', '20', '30', '31', '32']),
            'accept_location4' => fake()->randomElement(['01', '10', '12', '20', '30', '31', '32']),
            'accept_location5' => fake()->randomElement(['01', '10', '12', '20', '30', '31', '32']),
            'photo1' => fake()->randomElement(['sample1.png', 'sample2.jpg']),
        ];
    }
}
