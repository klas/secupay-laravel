<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ZeitraumSeeder::class,
            NutzerdetailsSeeder::class,
            VertragSeeder::class,
            ApiKeySeeder::class,
            TransaktionSeeder::class,
            DatensatzTypSeeder::class,
            FlagbitSeeder::class,
            FlagbitRefSeeder::class,
        ]);
    }
}
