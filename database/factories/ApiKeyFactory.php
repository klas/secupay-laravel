<?php

namespace Database\Factories;

use App\Models\ApiKey;
use App\Models\Vertrag;
use App\Models\Zeitraum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApiKeyFactory extends Factory
{
    protected $model = ApiKey::class;

    public function definition(): array
    {
        return [
            'apikey' => 'ak_' . Str::random(32),
            'vertrag_id' => Vertrag::factory(),
            'zeitraum_id' => Zeitraum::factory(),
            'ist_masterkey' => false,
            'bearbeiter_id' => $this->faker->numberBetween(1, 10),
        ];
    }

    public function masterKey(): static
    {
        return $this->state(fn (array $attributes) => [
            'ist_masterkey' => true,
        ]);
    }

    public function normalKey(): static
    {
        return $this->state(fn (array $attributes) => [
            'ist_masterkey' => false,
        ]);
    }

    public function forVertrag(Vertrag $vertrag): static
    {
        return $this->state(fn (array $attributes) => [
            'vertrag_id' => $vertrag->vertrag_id,
        ]);
    }

    public function forZeitraum(Zeitraum $zeitraum): static
    {
        return $this->state(fn (array $attributes) => [
            'zeitraum_id' => $zeitraum->zeitraum_id,
        ]);
    }

    public function byBearbeiter(int $bearbeiterId): static
    {
        return $this->state(fn (array $attributes) => [
            'bearbeiter_id' => $bearbeiterId,
        ]);
    }

    public function withValidZeitraum(): static
    {
        return $this->state(function (array $attributes) {
            $zeitraum = Zeitraum::factory()->create([
                'von' => now()->subMonth(),
                'bis' => now()->addYear(),
            ]);

            return [
                'zeitraum_id' => $zeitraum->zeitraum_id,
            ];
        });
    }

    public function withExpiredZeitraum(): static
    {
        return $this->state(function (array $attributes) {
            $zeitraum = Zeitraum::factory()->create([
                'von' => now()->subYear(),
                'bis' => now()->subMonth(),
            ]);

            return [
                'zeitraum_id' => $zeitraum->zeitraum_id,
            ];
        });
    }
}
