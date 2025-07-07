<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VertragSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vertragsverw_vertrag')->insert([
            ['vertrag_id' => 1, 'zeitraum_id' => 1, 'nutzer_id' => 2, 'Bearbeiter' => 1, 'erstelldatum' => '2020-09-01 00:00:00', 'timestamp' => '2020-09-01 00:00:00'],
            ['vertrag_id' => 2, 'zeitraum_id' => 2, 'nutzer_id' => 3, 'Bearbeiter' => 1, 'erstelldatum' => '2020-09-01 00:00:00', 'timestamp' => '2021-09-01 00:00:00'],
            ['vertrag_id' => 3, 'zeitraum_id' => 4, 'nutzer_id' => 2, 'Bearbeiter' => 1, 'erstelldatum' => '2021-09-01 00:00:00', 'timestamp' => '2021-09-01 00:00:00'],
        ]);
    }
}
