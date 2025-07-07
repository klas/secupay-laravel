<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('api_apikey', function (Blueprint $table) {
            $table->increments('apikey_id');
            $table->string('apikey')->unique();
            $table->unsignedBigInteger('vertrag_id');
            $table->unsignedBigInteger('zeitraum_id');
            $table->boolean('ist_masterkey')->default(false);
            $table->unsignedBigInteger('bearbeiter_id');
            $table->timestamp('timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->index('vertrag_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_apikey');
    }
};
