<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaktion extends Model
{
    protected $table = 'transaktion_transaktionen';
    protected $primaryKey = 'trans_id';
    public $timestamps = false;

    protected $fillable = [
        'trans_id',
        'produkt_id',
        'vertrag_id',
        'Betrag',
        'beschreibung',
        'waehrung_id',
        'bearbeiter',
        'erstelldatum'
    ];

    protected $casts = [
        'erstelldatum' => 'datetime',
        'timestamp' => 'datetime'
    ];

    public function vertrag(): BelongsTo
    {
        return $this->belongsTo(Vertrag::class, 'vertrag_id', 'vertrag_id');
    }

    public function flagbitRefs(): HasMany
    {
        return $this->hasMany(FlagbitRef::class, 'datensatz_id', 'trans_id')
                    ->where('datensatz_typ_id', 2);
    }

    public function activeFlagbitRefs(): HasMany
    {
        $now = now();
        return $this->flagbitRefs()
                    ->join('vorgaben_zeitraum', 'vorgaben_zeitraum.zeitraum_id', '=', 'stamd_flagbit_ref.zeitraum_id')
                    ->where('vorgaben_zeitraum.von', '<=', $now)
                    ->where('vorgaben_zeitraum.bis', '>=', $now);
    }
}
