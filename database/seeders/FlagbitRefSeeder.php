<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlagbitRefSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stamd_flagbit_ref')->insert([
            ['flagbit_ref_id' => 100, 'datensatz_typ_id' => 2, 'datensatz_id' => 1, 'flagbit' => 4, 'zeitraum_id' => 1, 'bearbeiter_id' => 2, 'timestamp' => '2020-10-01 12:05:00'],
            ['flagbit_ref_id' => 101, 'datensatz_typ_id' => 2, 'datensatz_id' => 2, 'flagbit' => 4, 'zeitraum_id' => 2, 'bearbeiter_id' => 3, 'timestamp' => '2021-03-01 14:55:54'],
            ['flagbit_ref_id' => 102, 'datensatz_typ_id' => 2, 'datensatz_id' => 3, 'flagbit' => 12, 'zeitraum_id' => 2, 'bearbeiter_id' => 2, 'timestamp' => '2021-09-01 13:15:58'],
        ]);
    }
}
