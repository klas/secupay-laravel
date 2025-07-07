<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlagbitRef extends Model
{
    protected $table = 'stamd_flagbit_ref';
    protected $primaryKey = 'flagbit_ref_id';
    public $timestamps = false;

    protected $fillable = [
        'datensatz_typ_id',
        'datensatz_id',
        'flagbit',
        'zeitraum_id',
        'bearbeiter_id'
    ];

    protected $casts = [
        'timestamp' => 'datetime'
    ];

    public function zeitraum(): BelongsTo
    {
        return $this->belongsTo(Zeitraum::class, 'zeitraum_id', 'zeitraum_id');
    }

    public function flagbitDefinition(): BelongsTo
    {
        return $this->belongsTo(Flagbit::class, 'flagbit', 'flagbit_id');
    }

    public function isActive(): bool
    {
        $now = now();
        return $this->zeitraum &&
               $now->between($this->zeitraum->von, $this->zeitraum->bis);
    }
}
