<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlagbitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vorgaben_flagbit')->insert([
            ['flagbit_id' => 1, 'beschreibung' => '0 = Direkt, 1 = Accounting', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 2, 'beschreibung' => '0 = keine ZG, 1 = ZG', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 3, 'beschreibung' => '0 = kein 3DSecure, 1 = 3DSecure', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 4, 'beschreibung' => '0 = XML, 1 = iFrame', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 5, 'beschreibung' => '0 = keine Demo, 1 = Demo', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 6, 'beschreibung' => '0 = keine Voraut. 1 = Voraut.', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 7, 'beschreibung' => '0 = keine Rückstellung, 1 = mit Rückstellung von Auszahlung', 'tabellen' => 'Transaktion-Hash (datensatz_typ_id 22)'],
            ['flagbit_id' => 8, 'beschreibung' => '0 = Stakeholderumbuchung nicht ausgeführt / nicht notwendig, 1 = Stakeholderumbuchung ausgeführt', 'tabellen' => 'Transaktion-Hash (datensatz_typ_id 22)'],
            ['flagbit_id' => 9, 'beschreibung' => '0 = Warenkorb nicht verarbeitet, 1 = Warenkorb vollständig verarbeitet', 'tabellen' => 'Transaktion-Hash (datensatz_typ_id 22)'],
            ['flagbit_id' => 10, 'beschreibung' => '0 = Warenkorbposition nicht verarbeitet / nicht notwendig, 1 = Warenkorbposition verarbeitet', 'tabellen' => 'api_basket_item_id (datensatz_typ_id 24)'],
            ['flagbit_id' => 11, 'beschreibung' => '1 = über Secucore erstellt', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 12, 'beschreibung' => '1 = für Checkout erstellt', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 13, 'beschreibung' => '0 = kein LVP, 1 = LVP', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 14, 'beschreibung' => '0 = kein TRA, 1 = TRA', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
            ['flagbit_id' => 15, 'beschreibung' => '0 = kein MIT, 1 = MIT', 'tabellen' => 'Transaktion (datensatz_typ_id 2)'],
        ]);
    }
}
