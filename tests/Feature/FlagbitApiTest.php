<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ApiKey;
use App\Models\Zeitraum;
use App\Models\Vertrag;
use App\Models\Transaktion;
use App\Models\FlagbitRef;
use App\Models\Flagbit;

class FlagbitApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestData();
    }

    private function seedTestData(): void
    {
        // Create time periods
        $activeZeitraum = Zeitraum::create([
            'von' => now()->subMonth(),
            'bis' => now()->addMonth()
        ]);

        $expiredZeitraum = Zeitraum::create([
            'von' => now()->subYears(2),
            'bis' => now()->subMonth()
        ]);

        // Create contracts
        $vertrag1 = Vertrag::create([
            'zeitraum_id' => $activeZeitraum->zeitraum_id,
            'nutzer_id' => 1,
            'Bearbeiter' => 1,
            'erstelldatum' => now()
        ]);

        $vertrag2 = Vertrag::create([
            'zeitraum_id' => $activeZeitraum->zeitraum_id,
            'nutzer_id' => 2,
            'Bearbeiter' => 1,
            'erstelldatum' => now()
        ]);

        // Create API keys
        ApiKey::create([
            'apikey' => 'test_key_user1',
            'vertrag_id' => $vertrag1->vertrag_id,
            'zeitraum_id' => $activeZeitraum->zeitraum_id,
            'ist_masterkey' => false,
            'bearbeiter_id' => 1
        ]);

        ApiKey::create([
            'apikey' => 'master_key_user1',
            'vertrag_id' => $vertrag1->vertrag_id,
            'zeitraum_id' => $activeZeitraum->zeitraum_id,
            'ist_masterkey' => true,
            'bearbeiter_id' => 1
        ]);

        ApiKey::create([
            'apikey' => 'test_key_user2',
            'vertrag_id' => $vertrag2->vertrag_id,
            'zeitraum_id' => $activeZeitraum->zeitraum_id,
            'ist_masterkey' => false,
            'bearbeiter_id' => 1
        ]);

        // Create transactions
        Transaktion::create([
            'trans_id' => 100,
            'produkt_id' => 1,
            'vertrag_id' => $vertrag1->vertrag_id,
            'Betrag' => 1000,
            'beschreibung' => 'Test transaction 1',
            'waehrung_id' => 1,
            'bearbeiter' => 1,
            'erstelldatum' => now()
        ]);

        Transaktion::create([
            'trans_id' => 200,
            'produkt_id' => 1,
            'vertrag_id' => $vertrag2->vertrag_id,
            'Betrag' => 2000,
            'beschreibung' => 'Test transaction 2',
            'waehrung_id' => 1,
            'bearbeiter' => 1,
            'erstelldatum' => now()
        ]);

        // Create flagbit definitions
        Flagbit::create([
            'flagbit_id' => 4,
            'beschreibung' => '0 = XML, 1 = iFrame',
            'tabellen' => 'Transaktion (datensatz_typ_id 2)'
        ]);

        Flagbit::create([
            'flagbit_id' => 12,
            'beschreibung' => '1 = für Checkout erstellt',
            'tabellen' => 'Transaktion (datensatz_typ_id 2)'
        ]);

        // Create active flagbit reference
        FlagbitRef::create([
            'datensatz_typ_id' => 2,
            'datensatz_id' => 100,
            'flagbit' => 4,
            'zeitraum_id' => $activeZeitraum->zeitraum_id,
            'bearbeiter_id' => 1
        ]);

        // Create expired flagbit reference
        FlagbitRef::create([
            'datensatz_typ_id' => 2,
            'datensatz_id' => 100,
            'flagbit' => 12,
            'zeitraum_id' => $expiredZeitraum->zeitraum_id,
            'bearbeiter_id' => 1
        ]);
    }

    public function test_get_active_flagbits_returns_only_active_flags(): void
    {
        $response = $this->getJson('/api/v1/flagbits/active?trans_id=100', [
            'Authorization' => 'test_key_user1'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'trans_id',
                        'active_flagbits' => [
                            '*' => [
                                'flagbit_id',
                                'name',
                                'description',
                                'set_at'
                            ]
                        ]
                ]]);

        $data = $response->json()['data'];
        $this->assertEquals(100, $data['trans_id']);
        $this->assertCount(1, $data['active_flagbits']);
        $this->assertEquals(4, $data['active_flagbits'][0]['flagbit_id']);
    }

    public function test_get_active_flagbits_rejects_access_to_other_users_transactions(): void
    {
        $response = $this->getJson('/api/v1/flagbits/active?trans_id=200', [
            'Authorization' => 'test_key_user1'
        ]);

        $response->assertStatus(404)
                ->assertJson(['message' => 'Transaction 200 not found or access denied']);
    }

    public function test_get_active_flagbits_validates_input(): void
    {
        $response = $this->getJson('/api/v1/flagbits/active', [
            'Authorization' => 'test_key_user1'
        ]);

        $response->assertStatus(422)
                ->assertJson(['message' => 'Transaction ID is required', 'success' => false]);
    }

    public function test_set_flagbit_validates_input(): void
    {
        $response = $this->postJson('/api/v1/flagbits/set', [
            'trans_id' => 100
            // missing flagbit_id
        ], [
            'Authorization' => 'master_key_user1'
        ]);

        $response->assertStatus(422);
    }

    public function test_set_flagbit_validates_flagbit_range(): void
    {
        $response = $this->postJson('/api/v1/flagbits/set', [
            'trans_id' => 100,
            'flagbit_id' => 999 // invalid range
        ], [
            'Authorization' => 'master_key_user1'
        ]);

        $response->assertStatus(422);
    }

    public function test_remove_flagbit_validates_input(): void
    {
        $response = $this->deleteJson('/api/v1/flagbits/remove', [
            'trans_id' => 100
            // missing flagbit_id
        ], [
            'Authorization' => 'master_key_user1'
        ]);

        $response->assertStatus(422);
    }

    public function test_get_flagbit_history_returns_all_historical_entries(): void
    {
        $response = $this->getJson('/api/v1/flagbits/history?trans_id=100', [
            'Authorization' => 'test_key_user1'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'trans_id',
                        'flagbit_history' => [
                            '*' => [
                                'flagbit_id',
                                'name',
                                'description',
                                'valid_from',
                                'valid_to',
                                'set_at',
                            ]
                        ]
                ]]);

        $data = $response->json()['data'];
        $this->assertEquals(100, $data['trans_id']);
        $this->assertCount(2, $data['flagbit_history']);


        // Check that is_active flag is correctly set
        $activeCount = collect($data['flagbit_history'])->where('is_active', true)->count();
        $this->assertEquals(1, $activeCount);
    }

    public function test_get_flagbit_history_rejects_access_to_other_users_transactions(): void
    {
        $response = $this->getJson('/api/v1/flagbits/history?trans_id=200', [
            'Authorization' => 'test_key_user1'
        ]);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Transaction 200 not found or access denied']);
    }
}
