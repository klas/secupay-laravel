<?php

namespace Tests\Unit\Services;

use App\Services\FlagbitService;
use App\Models\ApiKey;
use App\Models\Transaktion;
use App\Models\FlagbitRef;
use App\Exceptions\TransactionNotFoundException;
use App\Exceptions\InvalidFlagbitOperationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class FlagbitServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ApiKey $apiKey;
    protected FlagbitService $flagbitService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock ApiKey for all tests
        $this->apiKey = new ApiKey([
            'id' => 1,
            'vertrag_id' => 123,
            'bearbeiter_id' => 456,
            'is_master_key' => false,
        ]);

        $this->flagbitService = new FlagbitService();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_throws_exception_if_transaction_not_found_or_access_denied()
    {
        // Expect the exception
        $this->expectException(TransactionNotFoundException::class);

        // Mock the Transaktion model to find nothing
        $transaktionMock = Mockery::mock('alias:App\Models\Transaktion');
        $transaktionMock->shouldReceive('where')->with('trans_id', 1)->andReturnSelf();
        $transaktionMock->shouldReceive('where')->with('vertrag_id', $this->apiKey->vertrag_id)->andReturnSelf();
        $transaktionMock->shouldReceive('first')->andReturn(null);

        // Call the method that should fail
        $this->flagbitService->getActiveFlagbits(1, $this->apiKey);
    }

    public function test_get_active_flagbits_returns_filtered_collection()
    {
        // Mock a transaction so validation passes
        $transaktionMock = Mockery::mock('alias:App\Models\Transaktion');
        $transaktionMock->shouldReceive('where->where->first')->andReturn(new Transaktion());

        // Create standard mock objects for the collection
        $activeFlagbit = Mockery::mock('stdClass');
        $activeFlagbit->shouldReceive('isActive')->andReturn(true);

        $inactiveFlagbit = Mockery::mock('stdClass');
        $inactiveFlagbit->shouldReceive('isActive')->andReturn(false);

        // Mock the FlagbitRef model to return the collection of standard objects
        $flagbitRefMock = Mockery::mock('alias:App\Models\FlagbitRef');
        $flagbitRefMock->shouldReceive('with')->andReturnSelf();
        $flagbitRefMock->shouldReceive('where')->andReturnSelf();
        $flagbitRefMock->shouldReceive('get')->andReturn(new Collection([$activeFlagbit, $inactiveFlagbit]));

        $result = $this->flagbitService->getActiveFlagbits(1, $this->apiKey);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result); // Only the active one should be returned
    }

    public function test_set_flagbit_successfully()
    {
        // Mock transaction validation
        $transaktionMock = Mockery::mock('alias:App\Models\Transaktion');
        $transaktionMock->shouldReceive('where->where->first')->andReturn(new Transaktion());

        // Mock DB facade
        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });
        DB::shouldReceive('statement')->once();
        DB::shouldReceive('select')->once()->with('SELECT @error_code as error_code, @error_message as error_message')->andReturn([(object)['error_code' => 0, 'error_message' => '']]);

        $result = $this->flagbitService->setFlagbit(1, 5, $this->apiKey);

        $this->assertTrue($result);
    }


    public function test_set_flagbit_throws_exception_on_db_error()
    {
        $this->expectException(InvalidFlagbitOperationException::class);

        // Mock transaction validation
        $transaktionMock = Mockery::mock('alias:App\Models\Transaktion');
        $transaktionMock->shouldReceive('where->where->first')->andReturn(new Transaktion());

        // Mock DB facade to simulate an error
        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });
        DB::shouldReceive('statement');
        DB::shouldReceive('select')->andReturn([(object)['error_code' => 1, 'error_message' => 'DB error']]);

        $this->flagbitService->setFlagbit(1, 5, $this->apiKey);
    }

    public function test_remove_flagbit_successfully()
    {
        // Mock transaction validation
        $transaktionMock = Mockery::mock('alias:App\Models\Transaktion');
        $transaktionMock->shouldReceive('where->where->first')->andReturn(new Transaktion());

        // Mock DB facade
        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });
        DB::shouldReceive('statement')->once();
        DB::shouldReceive('select')->once()->with('SELECT @error_code as error_code, @error_message')->andReturn([(object)['error_code' => 0, 'error_message' => '']]);

        $result = $this->flagbitService->removeFlagbit(1, 5, $this->apiKey);

        $this->assertTrue($result);
    }

    public function test_remove_flagbit_throws_exception_on_db_error()
    {
        $this->expectException(InvalidFlagbitOperationException::class);

        // Mock transaction validation
        $transaktionMock = Mockery::mock('alias:App\Models\Transaktion');
        $transaktionMock->shouldReceive('where->where->first')->andReturn(new Transaktion());

        // Mock DB facade to simulate an error
        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });
        DB::shouldReceive('statement');
        DB::shouldReceive('select')->andReturn([(object)['error_code' => 1, 'error_message' => 'DB error']]);

        $this->flagbitService->removeFlagbit(1, 5, $this->apiKey);
    }
}
