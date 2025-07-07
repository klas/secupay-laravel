<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiKey extends Model
{
    protected $table = 'api_apikey';
    protected $primaryKey = 'apikey_id';
    public $timestamps = false;

    protected $fillable = [
        'apikey',
        'vertrag_id',
        'zeitraum_id',
        'ist_masterkey',
        'bearbeiter_id'
    ];

    protected $casts = [
        'ist_masterkey' => 'boolean',
        'timestamp' => 'datetime'
    ];

    public function zeitraum(): BelongsTo
    {
        return $this->belongsTo(Zeitraum::class, 'zeitraum_id', 'zeitraum_id');
    }

    public function vertrag(): BelongsTo
    {
        return $this->belongsTo(Vertrag::class, 'vertrag_id', 'vertrag_id');
    }

    public function isValid(): bool
    {
        $now = now();
        return $this->zeitraum &&
               $now->between($this->zeitraum->von, $this->zeitraum->bis);
    }
}
