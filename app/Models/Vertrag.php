<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vertrag extends Model
{
    protected $table = 'vertragsverw_vertrag';
    protected $primaryKey = 'vertrag_id';
    public $timestamps = false;

    protected $fillable = [
        'zeitraum_id',
        'nutzer_id',
        'Bearbeiter',
        'erstelldatum'
    ];

    protected $casts = [
        'erstelldatum' => 'datetime',
        'timestamp' => 'datetime'
    ];

    public function transaktionen(): HasMany
    {
        return $this->hasMany(Transaktion::class, 'vertrag_id', 'vertrag_id');
    }
}
