<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vertragsverw_vertrag', function (Blueprint $table) {
            $table->bigIncrements('vertrag_id');
            $table->unsignedBigInteger('zeitraum_id');
            $table->unsignedBigInteger('nutzer_id');
            $table->unsignedBigInteger('Bearbeiter');
            $table->dateTime('erstelldatum')->nullable()->useCurrent();
            $table->dateTime('timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->index('nutzer_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vertragsverw_vertrag');
    }
};
