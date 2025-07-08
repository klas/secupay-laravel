<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function get_server_time_returns_correct_json_response()
    {
        $controller = new ApiController();
        $response = $controller->getServerTime();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('server_time', $data);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertArrayHasKey('timezone', $data);
        $this->assertEquals(config('app.timezone'), $data['timezone']);
    }
}
