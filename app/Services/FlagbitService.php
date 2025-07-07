<?php

namespace App\Services;

use App\Models\ApiKey;
use App\Models\Transaktion;
use App\Models\FlagbitRef;
use App\Constants\DataFlag;
use App\Exceptions\TransactionNotFoundException;
use App\Exceptions\InvalidFlagbitOperationException;
use Illuminate\Support\Facades\DB;

class FlagbitService
{
    public function getActiveFlagbits(int $transId, ApiKey $apiKey): array
    {
        $transaction = Transaktion::where('trans_id', $transId)
            ->where('vertrag_id', $apiKey->vertrag_id)
            ->first();

        if (!$transaction) {
            throw new TransactionNotFoundException("Transaction {$transId} not found or access denied");
        }

        $now = now();

        $flagbits = FlagbitRef::select([
            'stamd_flagbit_ref.flagbit',
            'vorgaben_flagbit.beschreibung',
            'stamd_flagbit_ref.timestamp as set_at'
        ])
            ->join('vorgaben_zeitraum', 'vorgaben_zeitraum.zeitraum_id', '=', 'stamd_flagbit_ref.zeitraum_id')
            ->leftJoin('vorgaben_flagbit', 'vorgaben_flagbit.flagbit_id', '=', 'stamd_flagbit_ref.flagbit')
            ->where('stamd_flagbit_ref.datensatz_typ_id', 2)
            ->where('stamd_flagbit_ref.datensatz_id', $transId)
            ->where('vorgaben_zeitraum.von', '<=', $now)
            ->where('vorgaben_zeitraum.bis', '>=', $now)
            ->get();

        return $flagbits->map(function ($flagbit) {
            return [
                'flagbit_id' => $flagbit->flagbit,
                'name' => DataFlag::getFlagName($flagbit->flagbit),
                'description' => $flagbit->beschreibung,
                'set_at' => $flagbit->set_at
            ];
        })->toArray();
    }

    public function setFlagbit(int $transId, int $flagbitId, ApiKey $apiKey): bool
    {
        $transaction = Transaktion::where('trans_id', $transId)
            ->where('vertrag_id', $apiKey->vertrag_id)
            ->first();

        if (!$transaction) {
            throw new TransactionNotFoundException("Transaction {$transId} not found or access denied");
        }

        return DB::transaction(function () use ($transId, $flagbitId, $apiKey) {
            DB::statement('CALL stamd_aendern_erstellen_flagbit_ref(?, ?, ?, ?, ?, @error_code, @error_message)', [
                2, $transId, $flagbitId, 1, $apiKey->bearbeiter_id
            ]);

            $result = DB::select('SELECT @error_code as error_code, @error_message as error_message')[0];

            if ($result->error_code != 0) {
                throw new InvalidFlagbitOperationException(
                    $result->error_message ?: "Failed to set flagbit {$flagbitId} for transaction {$transId}"
                );
            }

            return true;
        });
    }

    public function removeFlagbit(int $transId, int $flagbitId, ApiKey $apiKey): bool
    {
        $transaction = Transaktion::where('trans_id', $transId)
            ->where('vertrag_id', $apiKey->vertrag_id)
            ->first();

        if (!$transaction) {
            throw new TransactionNotFoundException("Transaction {$transId} not found or access denied");
        }

        return DB::transaction(function () use ($transId, $flagbitId, $apiKey) {
            DB::statement('CALL stamd_aendern_erstellen_flagbit_ref(?, ?, ?, ?, ?, @error_code, @error_message)', [
                2, $transId, $flagbitId, 0, $apiKey->bearbeiter_id
            ]);

            $result = DB::select('SELECT @error_code as error_code, @error_message')[0];

            if ($result->error_code != 0) {
                throw new InvalidFlagbitOperationException(
                    $result->error_message ?: "Failed to remove flagbit {$flagbitId} from transaction {$transId}"
                );
            }

            return true;
        });
    }

    public function getFlagbitHistory(int $transId, ApiKey $apiKey): array
    {
        $transaction = Transaktion::where('trans_id', $transId)
            ->where('vertrag_id', $apiKey->vertrag_id)
            ->first();

        if (!$transaction) {
            throw new TransactionNotFoundException("Transaction {$transId} not found or access denied");
        }

        $history = FlagbitRef::select([
            'stamd_flagbit_ref.flagbit',
            'vorgaben_flagbit.beschreibung',
            'vorgaben_zeitraum.von as valid_from',
            'vorgaben_zeitraum.bis as valid_to',
            'stamd_flagbit_ref.timestamp as set_at'
        ])
            ->join('vorgaben_zeitraum', 'vorgaben_zeitraum.zeitraum_id', '=', 'stamd_flagbit_ref.zeitraum_id')
            ->leftJoin('vorgaben_flagbit', 'vorgaben_flagbit.flagbit_id', '=', 'stamd_flagbit_ref.flagbit')
            ->where('stamd_flagbit_ref.datensatz_typ_id', 2)
            ->where('stamd_flagbit_ref.datensatz_id', $transId)
            ->orderBy('stamd_flagbit_ref.timestamp', 'desc')
            ->get();

        return $history->map(function ($item) {
            $now = now();
            $isActive = $now->between($item->valid_from, $item->valid_to);

            return [
                'flagbit_id' => $item->flagbit,
                'name' => DataFlag::getFlagName($item->flagbit),
                'description' => $item->beschreibung,
                'valid_from' => $item->valid_from,
                'valid_to' => $item->valid_to,
                'set_at' => $item->set_at,
                'is_active' => $isActive
            ];
        })->toArray();
    }
}
