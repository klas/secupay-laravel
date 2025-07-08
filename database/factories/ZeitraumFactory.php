<?php

namespace Database\Factories;

use App\Models\Zeitraum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZeitraumFactory extends Factory
{
    protected $model = Zeitraum::class;

    public function definition(): array
    {
        $von = $this->faker->dateTimeBetween('-2 years', 'now');
        $bis = $this->faker->dateTimeBetween($von, '+2 years');

        return [
            'von' => $von,
            'bis' => $bis,
        ];
    }

    public function currentlyValid(): static
    {
        return $this->state(fn (array $attributes) => [
            'von' => now()->subMonth(),
            'bis' => now()->addYear(),
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'von' => now()->subYears(2),
            'bis' => now()->subYear(),
        ]);
    }

    public function future(): static
    {
        return $this->state(fn (array $attributes) => [
            'von' => now()->addMonth(),
            'bis' => now()->addYear(),
        ]);
    }
}
