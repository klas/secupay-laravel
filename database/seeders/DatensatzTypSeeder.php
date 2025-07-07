<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatensatzTypSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['datensatz_typ_id' => 1, 'beschreibung' => 'nutzer_id'],
            ['datensatz_typ_id' => 2, 'beschreibung' => 'trans_id'],
            ['datensatz_typ_id' => 3, 'beschreibung' => 'karten_id'],
            ['datensatz_typ_id' => 4, 'beschreibung' => 'vertrag_id'],
            ['datensatz_typ_id' => 5, 'beschreibung' => 'zahlungsmittel_id'],
            ['datensatz_typ_id' => 6, 'beschreibung' => 'terminal_id'],
            ['datensatz_typ_id' => 7, 'beschreibung' => 'adr_id'],
            ['datensatz_typ_id' => 8, 'beschreibung' => 'hash_id'],
            ['datensatz_typ_id' => 9, 'beschreibung' => 'plz_normiert_id'],
            ['datensatz_typ_id' => 10, 'beschreibung' => 'branche_id'],
            ['datensatz_typ_id' => 11, 'beschreibung' => 'tid_id'],
            ['datensatz_typ_id' => 12, 'beschreibung' => 'mail_domain_id'],
            ['datensatz_typ_id' => 13, 'beschreibung' => 'bankengruppe_id'],
            ['datensatz_typ_id' => 14, 'beschreibung' => 'land_id für adr_id'],
            ['datensatz_typ_id' => 15, 'beschreibung' => 'zahlungsmittelcontainer_id'],
            ['datensatz_typ_id' => 16, 'beschreibung' => 'iin_id'],
            ['datensatz_typ_id' => 17, 'beschreibung' => 'land_id für iin_id'],
            ['datensatz_typ_id' => 18, 'beschreibung' => 'login (nutzer_id aus nutzer_logindaten)'],
            ['datensatz_typ_id' => 19, 'beschreibung' => 'mail_id'],
            ['datensatz_typ_id' => 20, 'beschreibung' => 'apikey_id (api_apikey)'],
            ['datensatz_typ_id' => 21, 'beschreibung' => 'merchant_whitelist_id'],
            ['datensatz_typ_id' => 22, 'beschreibung' => 'trans_hash_id'],
            ['datensatz_typ_id' => 23, 'beschreibung' => 'name_id'],
            ['datensatz_typ_id' => 24, 'beschreibung' => 'basket_item_id'],
            ['datensatz_typ_id' => 25, 'beschreibung' => 'kartengruppe_id'],
            ['datensatz_typ_id' => 26, 'beschreibung' => 'fall_id'],
            ['datensatz_typ_id' => 27, 'beschreibung' => 'servicekontakt_id'],
            ['datensatz_typ_id' => 28, 'beschreibung' => 'ean_id'],
            ['datensatz_typ_id' => 29, 'beschreibung' => 'wert_id'],
            ['datensatz_typ_id' => 30, 'beschreibung' => 'produkt_id'],
            ['datensatz_typ_id' => 31, 'beschreibung' => 'produktart_id'],
            ['datensatz_typ_id' => 32, 'beschreibung' => 'produkt_typ_id'],
            ['datensatz_typ_id' => 33, 'beschreibung' => 'nutzer_adress_id'],
            ['datensatz_typ_id' => 34, 'beschreibung' => 'nutzer_telefon_id'],
            ['datensatz_typ_id' => 35, 'beschreibung' => 'nutzer_email_id'],
        ];

        DB::table('vorgaben_datensatz_typ')->insert($types);
    }
}
