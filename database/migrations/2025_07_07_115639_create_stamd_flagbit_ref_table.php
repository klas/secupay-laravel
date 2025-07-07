<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stamd_flagbit_ref', function (Blueprint $table) {
            $table->bigIncrements('flagbit_ref_id');
            $table->unsignedInteger('datensatz_typ_id');
            $table->unsignedBigInteger('datensatz_id');
            $table->unsignedBigInteger('flagbit');
            $table->unsignedBigInteger('zeitraum_id');
            $table->unsignedBigInteger('bearbeiter_id');
            $table->timestamp('timestamp')->useCurrent()->useCurrentOnUpdate();

            $table->index('datensatz_typ_id');
            $table->index('datensatz_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stamd_flagbit_ref');
    }
};
