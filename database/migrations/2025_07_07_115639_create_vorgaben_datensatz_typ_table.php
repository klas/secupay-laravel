<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vorgaben_datensatz_typ', function (Blueprint $table) {
            $table->increments('datensatz_typ_id');
            $table->string('beschreibung')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vorgaben_datensatz_typ');
    }
};
