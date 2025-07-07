<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NutzerdetailsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stamd_nutzerdetails')->insert([
            ['nutzerdetails_id' => 1, 'name' => 'Admin User', 'Bearbeiter' => null, 'timestamp' => '2020-01-01 00:00:00'],
            ['nutzerdetails_id' => 2, 'name' => 'Merchant A', 'Bearbeiter' => 1, 'timestamp' => '2020-09-01 00:00:00'],
            ['nutzerdetails_id' => 3, 'name' => 'Merchant B', 'Bearbeiter' => 1, 'timestamp' => '2020-09-01 00:00:00'],
            ['nutzerdetails_id' => 4, 'name' => 'User', 'Bearbeiter' => 1, 'timestamp' => '2021-01-01 00:00:00'],
        ]);
    }
}
