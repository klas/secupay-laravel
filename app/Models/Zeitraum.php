<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zeitraum extends Model
{
    protected $table = 'vorgaben_zeitraum';
    protected $primaryKey = 'zeitraum_id';
    public $timestamps = false;

    protected $fillable = ['von', 'bis'];

    protected $casts = [
        'von' => 'datetime',
        'bis' => 'datetime'
    ];
}
