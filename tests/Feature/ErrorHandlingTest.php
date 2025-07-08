<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\ApiKey;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ErrorHandlingTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_not_found_returns_proper_error()
    {
        $apiKey = ApiKey::factory()->withValidZeitraum()->create();

        $response = $this->withHeaders([
            'Authorization' => $apiKey->apikey,
        ])->get('/api/v1/flagbits/active?trans_id=99999');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'success',
                'data',
                'status'
            ]);
    }

    public function test_validation_errors_are_handled()
    {
        $apiKey = ApiKey::factory()->withValidZeitraum()->create();

        $response = $this->withHeaders([
            'Authorization' => $apiKey->apikey,
        ])->get('/api/v1/flagbits/active'); // Missing trans_id

        $response->assertStatus(422); // Validation error
    }
}
