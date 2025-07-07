<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flagbit extends Model
{
    protected $table = 'vorgaben_flagbit';
    protected $primaryKey = 'flagbit_id';
    public $timestamps = false;

    protected $fillable = ['beschreibung', 'tabellen'];
}
