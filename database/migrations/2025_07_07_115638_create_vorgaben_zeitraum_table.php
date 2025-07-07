<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vorgaben_zeitraum', function (Blueprint $table) {
            $table->bigIncrements('zeitraum_id');
            $table->dateTime('von');
            $table->dateTime('bis');
            $table->unique(['von', 'bis']);
            $table->index('von');
            $table->index('bis');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vorgaben_zeitraum');
    }
};
