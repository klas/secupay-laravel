<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stamd_nutzerdetails', function (Blueprint $table) {
            $table->bigIncrements('nutzerdetails_id');
            $table->string('name')->default('');
            $table->unsignedBigInteger('Bearbeiter')->nullable();
            $table->timestamp('timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->index('name');
            $table->index('timestamp');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stamd_nutzerdetails');
    }
};
