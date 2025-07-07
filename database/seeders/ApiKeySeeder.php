<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiKeySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('api_apikey')->insert([
            ['apikey_id' => 1, 'apikey' => '99f26159eb7a50784a9006fa35a5dbe32e604fee', 'vertrag_id' => 1, 'zeitraum_id' => 1, 'ist_masterkey' => 0, 'bearbeiter_id' => 1, 'timestamp' => '2020-09-01 00:00:00'],
            ['apikey_id' => 2, 'apikey' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9', 'vertrag_id' => 2, 'zeitraum_id' => 1, 'ist_masterkey' => 0, 'bearbeiter_id' => 1, 'timestamp' => '2020-09-01 00:00:00'],
            ['apikey_id' => 3, 'apikey' => '9faa37b23f350c516e3589e60083d10cd368df01', 'vertrag_id' => 3, 'zeitraum_id' => 4, 'ist_masterkey' => 0, 'bearbeiter_id' => 1, 'timestamp' => '2021-09-01 00:00:00'],
            ['apikey_id' => 4, 'apikey' => '8067562d7138d72501485941246cf9b229c3a46a', 'vertrag_id' => 2, 'zeitraum_id' => 4, 'ist_masterkey' => 1, 'bearbeiter_id' => 1, 'timestamp' => '2021-09-01 00:00:00'],
        ]);
    }
}
