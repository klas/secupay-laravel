<?php

namespace Database\Factories;

use App\Models\Vertrag;
use App\Models\Zeitraum;
use Illuminate\Database\Eloquent\Factories\Factory;

class VertragFactory extends Factory
{
    protected $model = Vertrag::class;

    public function definition(): array
    {
        return [
            'zeitraum_id' => Zeitraum::factory(),
            'nutzer_id' => $this->faker->numberBetween(1, 100),
            'Bearbeiter' => $this->faker->numberBetween(1, 10),
            'erstelldatum' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function forNutzer(int $nutzerId): static
    {
        return $this->state(fn (array $attributes) => [
            'nutzer_id' => $nutzerId,
        ]);
    }

    public function byBearbeiter(int $bearbeiterId): static
    {
        return $this->state(fn (array $attributes) => [
            'Bearbeiter' => $bearbeiterId,
        ]);
    }

    public function forZeitraum(Zeitraum $zeitraum): static
    {
        return $this->state(fn (array $attributes) => [
            'zeitraum_id' => $zeitraum->zeitraum_id,
        ]);
    }

    public function withValidZeitraum(): static
    {
        return $this->state(function (array $attributes) {
            $zeitraum = Zeitraum::factory()->currentlyValid()->create();

            return [
                'zeitraum_id' => $zeitraum->zeitraum_id,
            ];
        });
    }
}
