<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vorgaben_flagbit', function (Blueprint $table) {
            $table->increments('flagbit_id');
            $table->string('beschreibung')->nullable();
            $table->string('tabellen')->nullable()->comment('nur als notiz, wird nicht ausgewertet');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vorgaben_flagbit');
    }
};
