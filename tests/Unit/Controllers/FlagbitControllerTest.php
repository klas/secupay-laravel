<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\Api\FlagbitController;
use App\Services\FlagbitService;
use App\Http\Requests\GetActiveFlagbitsRequest;
use App\Http\Requests\SetFlagbitRequest;
use App\Http\Requests\RemoveFlagbitRequest;
use App\Http\Requests\GetFlagbitHistoryRequest;
use App\Models\ApiKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FlagbitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected FlagbitService $flagbitServiceMock;
    protected FlagbitController $flagbitController;
    protected ApiKey $apiKey;

    protected function setUp(): void
    {
        parent::setUp();

        $this->flagbitServiceMock = Mockery::mock(FlagbitService::class);
        $this->flagbitController = new FlagbitController($this->flagbitServiceMock);

        $this->apiKey = new ApiKey(['id' => 1]);
        // Associate the API key with a mock request for the controller methods to use
        $this->app->instance(ApiKey::class, $this->apiKey);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function get_active_flagbits_returns_correct_json_response()
    {
        $request = Mockery::mock(GetActiveFlagbitsRequest::class);
        $request->shouldReceive('validatedData')->andReturn(['trans_id' => 1, 'api_key' => $this->apiKey]);

        $this->flagbitServiceMock
            ->shouldReceive('getActiveFlagbits')
            ->with(1, $this->apiKey)
            ->once()
            ->andReturn(new Collection());

        $response = $this->flagbitController->getActiveFlagbits($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    #[Test]
    public function set_flagbit_returns_correct_json_response()
    {
        $requestData = ['trans_id' => 1, 'flagbit_id' => 5];
        $request = Mockery::mock(SetFlagbitRequest::class);
        $request->shouldReceive('validatedData')->andReturn($requestData + ['api_key' => $this->apiKey]);

        $this->flagbitServiceMock
            ->shouldReceive('setFlagbit')
            ->with(1, 5, $this->apiKey)
            ->once()
            ->andReturn(true);

        $response = $this->flagbitController->setFlagbit($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $responseData = $response->getData(true);
        $this->assertEquals('success', $responseData['status']);
        $this->assertEquals('set', $responseData['data']['action']);
        $this->assertEquals(1, $responseData['data']['trans_id']);
        $this->assertEquals(5, $responseData['data']['flagbit_id']);
        $this->assertArrayHasKey('message', $responseData['data']);
        $this->assertArrayHasKey('timestamp', $responseData['data']);
    }

    #[Test]
    public function remove_flagbit_returns_correct_json_response()
    {
        $requestData = ['trans_id' => 1, 'flagbit_id' => 5];
        $request = Mockery::mock(RemoveFlagbitRequest::class);
        $request->shouldReceive('validatedData')->andReturn($requestData + ['api_key' => $this->apiKey]);

        $this->flagbitServiceMock
            ->shouldReceive('removeFlagbit')
            ->with(1, 5, $this->apiKey)
            ->once()
            ->andReturn(true);

        $response = $this->flagbitController->removeFlagbit($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $responseData = $response->getData(true);
        $this->assertEquals('success', $responseData['status']);
        $this->assertEquals('remove', $responseData['data']['action']);
        $this->assertEquals(1, $responseData['data']['trans_id']);
        $this->assertEquals(5, $responseData['data']['flagbit_id']);
        $this->assertArrayHasKey('message', $responseData['data']);
        $this->assertArrayHasKey('timestamp', $responseData['data']);
    }

    #[Test]
    public function get_flagbit_history_returns_correct_json_response()
    {
        $request = Mockery::mock(GetFlagbitHistoryRequest::class);
        $request->shouldReceive('validatedData')->andReturn(['trans_id' => 1, 'api_key' => $this->apiKey]);

        $this->flagbitServiceMock
            ->shouldReceive('getFlagbitHistory')
            ->with(1, $this->apiKey)
            ->once()
            ->andReturn(new Collection());

        $response = $this->flagbitController->getFlagbitHistory($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
