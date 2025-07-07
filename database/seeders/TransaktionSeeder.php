<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaktionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transaktion_transaktionen')->insert([
            ['trans_id' => 1, 'produkt_id' => 1, 'vertrag_id' => 1, 'Betrag' => 123, 'beschreibung' => 'Order #1', 'waehrung_id' => 1, 'bearbeiter' => 2, 'erstelldatum' => '2020-10-01 12:05:00', 'timestamp' => '2020-10-01 12:05:00'],
            ['trans_id' => 2, 'produkt_id' => 1, 'vertrag_id' => 2, 'Betrag' => 45, 'beschreibung' => 'Order #2', 'waehrung_id' => 1, 'bearbeiter' => 3, 'erstelldatum' => '2021-03-01 14:55:54', 'timestamp' => '2021-03-01 14:55:54'],
            ['trans_id' => 3, 'produkt_id' => 1, 'vertrag_id' => 3, 'Betrag' => 234, 'beschreibung' => 'Order #3', 'waehrung_id' => 1, 'bearbeiter' => 2, 'erstelldatum' => '2021-09-01 13:15:58', 'timestamp' => '2021-09-01 13:15:58'],
            ['trans_id' => 4, 'produkt_id' => 1, 'vertrag_id' => 2, 'Betrag' => 23, 'beschreibung' => 'Order #4', 'waehrung_id' => 1, 'bearbeiter' => 3, 'erstelldatum' => '2021-09-02 00:26:44', 'timestamp' => '2021-09-02 00:26:44'],
        ]);
    }
}
