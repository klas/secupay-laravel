<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTimeTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_server_time_returns_current_time(): void
    {
        $response = $this->getJson('/api/v1/time');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'server_time',
                    'timestamp',
                    'timezone'
                ]);

        $data = $response->json();
        $this->assertIsString($data['server_time']);
        $this->assertIsInt($data['timestamp']);
        $this->assertEquals(config('app.timezone'), $data['timezone']);
    }

    public function test_server_time_is_recent(): void
    {
        $beforeRequest = Carbon::createFromTimestamp(now()->timestamp);
        $response = $this->getJson('/api/v1/time');
        $afterRequest = Carbon::createFromTimestamp(now()->timestamp);

        $response->assertStatus(200);

        $data = $response->json();
        $responseTime = Carbon::createFromTimestamp($data['timestamp']);

        $this->assertTrue($responseTime->between($beforeRequest, $afterRequest));
    }
}
