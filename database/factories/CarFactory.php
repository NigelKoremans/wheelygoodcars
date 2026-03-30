<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'license_plate' => strtoupper($this->faker->bothify('??-##-??')),
            'make' => $this->faker->company(),
            'model' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 1000, 50000),
            'mileage' => $this->faker->numberBetween(0, 300000),
            'seats' => $this->faker->numberBetween(2, 7),
            'doors' => $this->faker->numberBetween(3, 5),
            'production_year' => $this->faker->year(),
            'weight' => $this->faker->numberBetween(800, 3000),
            'color' => $this->faker->safeColorName(),
            'image' => null,
            'sold_at' => $this->faker->optional(0.1)->dateTime(),
            'views' => $this->faker->numberBetween(0, 500),
        ];
    }
}
