<?php

namespace App\Services;

use App\Models\ApiKey;
use App\Models\Transaktion;
use App\Models\FlagbitRef;
use App\Exceptions\TransactionNotFoundException;
use App\Exceptions\InvalidFlagbitOperationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FlagbitService
{
    public function getActiveFlagbits(int $transId, ?ApiKey $apiKey): Collection
    {
        $this->validateTransactionAccess($transId, $apiKey);

        return FlagbitRef::with(['zeitraum', 'flagbitDefinition'])
            ->where('datensatz_typ_id', 2)
            ->where('datensatz_id', $transId)
            ->get()
            ->filter->isActive()->values();
    }

    public function setFlagbit(int $transId, int $flagbitId, ?ApiKey $apiKey): bool
    {
        $this->validateTransactionAccess($transId, $apiKey);

        return DB::transaction(function () use ($transId, $flagbitId, $apiKey) {
            DB::statement('CALL stamd_aendern_erstellen_flagbit_ref(?, ?, ?, ?, ?, @error_code, @error_message)', [
                2, $transId, $flagbitId, 1, $apiKey->bearbeiter_id
            ]);

            $result = DB::select('SELECT @error_code as error_code, @error_message as error_message')[0];

            if ($result->error_code != 0) {
                throw new InvalidFlagbitOperationException(
                    $result->error_message ?? "Failed to set flagbit {$flagbitId} for transaction {$transId}"
                );
            }

            return true;
        });
    }

    public function removeFlagbit(int $transId, int $flagbitId, ?ApiKey $apiKey): bool
    {
        $this->validateTransactionAccess($transId, $apiKey);

        return DB::transaction(function () use ($transId, $flagbitId, $apiKey) {
            DB::statement('CALL stamd_aendern_erstellen_flagbit_ref(?, ?, ?, ?, ?, @error_code, @error_message)', [
                2, $transId, $flagbitId, 2, $apiKey->bearbeiter_id
            ]);

            $result = DB::select('SELECT @error_code as error_code, @error_message as error_message')[0];

            if ($result->error_code != 0) {
                throw new InvalidFlagbitOperationException(
                    $result->error_message ?? "Failed to remove flagbit {$flagbitId} from transaction {$transId}"
                );
            }

            return true;
        });
    }

    public function getFlagbitHistory(int $transId, ?ApiKey $apiKey): Collection
    {
        $this->validateTransactionAccess($transId, $apiKey);

        return FlagbitRef::with(['zeitraum', 'flagbitDefinition'])
            ->where('datensatz_typ_id', 2)
            ->where('datensatz_id', $transId)
            ->orderBy('timestamp', 'desc')
            ->get();
    }

    private function validateTransactionAccess(int $transId, ?ApiKey $apiKey): Transaktion
    {
        $transaction = Transaktion::where('trans_id', $transId)
            ->where('vertrag_id', $apiKey->vertrag_id)
            ->first();

        if (!$transaction) {
            throw new TransactionNotFoundException("Transaction {$transId} not found or access denied");
        }

        return $transaction;
    }
}
