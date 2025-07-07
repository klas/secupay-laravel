<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZeitraumSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vorgaben_zeitraum')->insert([
            ['zeitraum_id' => 1, 'von' => '2020-09-01 00:00:00', 'bis' => '2021-09-01 00:00:00'],
            ['zeitraum_id' => 2, 'von' => '2020-09-01 00:00:00', 'bis' => '2030-10-01 00:00:00'],
            ['zeitraum_id' => 3, 'von' => '2021-06-01 00:00:00', 'bis' => '2030-09-01 00:00:00'],
            ['zeitraum_id' => 4, 'von' => '2021-09-01 00:00:00', 'bis' => '2030-10-01 00:00:00'],
        ]);
    }
}
