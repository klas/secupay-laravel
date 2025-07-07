<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ApiKey;
use App\Models\Zeitraum;
use App\Models\Vertrag;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestData();
    }

    private function seedTestData(): void
    {
        // Create valid time period
        $zeitraum = Zeitraum::create([
            'von' => now()->subYear(),
            'bis' => now()->addYear()
        ]);

        // Create expired time period
        $expiredZeitraum = Zeitraum::create([
            'von' => now()->subYears(2),
            'bis' => now()->subYear()
        ]);

        // Create contract
        $vertrag = Vertrag::create([
            'zeitraum_id' => $zeitraum->zeitraum_id,
            'nutzer_id' => 1,
            'Bearbeiter' => 1,
            'erstelldatum' => now()
        ]);

        // Create valid API key
        ApiKey::create([
            'apikey' => 'valid_test_key',
            'vertrag_id' => $vertrag->vertrag_id,
            'zeitraum_id' => $zeitraum->zeitraum_id,
            'ist_masterkey' => false,
            'bearbeiter_id' => 1
        ]);

        // Create valid master key
        ApiKey::create([
            'apikey' => 'valid_master_key',
            'vertrag_id' => $vertrag->vertrag_id,
            'zeitraum_id' => $zeitraum->zeitraum_id,
            'ist_masterkey' => true,
            'bearbeiter_id' => 1
        ]);

        // Create expired API key
        ApiKey::create([
            'apikey' => 'expired_test_key',
            'vertrag_id' => $vertrag->vertrag_id,
            'zeitraum_id' => $expiredZeitraum->zeitraum_id,
            'ist_masterkey' => false,
            'bearbeiter_id' => 1
        ]);
    }

    public function test_protected_endpoint_requires_api_key(): void
    {
        $response = $this->getJson('/api/flagbits/active?trans_id=1');

        $response->assertStatus(401)
                ->assertJson(['error' => 'API key required']);
    }

    public function test_protected_endpoint_rejects_invalid_api_key(): void
    {
        $response = $this->getJson('/api/flagbits/active?trans_id=1', [
            'Authorization' => 'invalid_key'
        ]);

        $response->assertStatus(401)
                ->assertJson(['error' => 'Invalid or expired API key']);
    }

    public function test_protected_endpoint_rejects_expired_api_key(): void
    {
        $response = $this->getJson('/api/flagbits/active?trans_id=1', [
            'Authorization' => 'expired_test_key'
        ]);

        $response->assertStatus(401)
                ->assertJson(['error' => 'Invalid or expired API key']);
    }

    public function test_protected_endpoint_accepts_valid_api_key(): void
    {
        $response = $this->getJson('/api/flagbits/active?trans_id=1', [
            'Authorization' => 'valid_test_key'
        ]);

        // Should not be 401 (may be 404 if transaction doesn't exist, but auth should pass)
        $response->assertStatus(404);
    }

    public function test_master_key_endpoint_rejects_regular_key(): void
    {
        $response = $this->postJson('/api/flagbits/set', [
            'trans_id' => 1,
            'flagbit_id' => 4
        ], [
            'Authorization' => 'valid_test_key'
        ]);

        $response->assertStatus(403)
                ->assertJson(['error' => 'Master key required']);
    }

    public function test_master_key_endpoint_accepts_master_key(): void
    {
        $response = $this->postJson('/api/flagbits/set', [
            'trans_id' => 1,
            'flagbit_id' => 4
        ], [
            'Authorization' => 'valid_master_key'
        ]);

        // Should not be 403 (may be 404 if transaction doesn't exist, but auth should pass)
        $response->assertStatus(404);
    }

    public function test_bearer_token_format_is_supported(): void
    {
        $response = $this->getJson('/api/flagbits/active?trans_id=1', [
            'Authorization' => 'Bearer valid_test_key'
        ]);

        $response->assertStatus(404); // Transaction not found, but auth passed
    }
}
