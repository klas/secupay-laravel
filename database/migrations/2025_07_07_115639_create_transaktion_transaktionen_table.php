<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaktion_transaktionen', function (Blueprint $table) {
            $table->bigIncrements('trans_id');
            $table->integer('produkt_id');
            $table->unsignedBigInteger('vertrag_id');
            $table->unsignedBigInteger('Betrag');
            $table->text('beschreibung')->nullable();
            $table->unsignedInteger('waehrung_id')->default(1);
            $table->unsignedBigInteger('bearbeiter');
            $table->dateTime('erstelldatum')->nullable();
            $table->timestamp('timestamp')->useCurrent()->useCurrentOnUpdate();

            $table->index('Betrag');
            $table->index('erstelldatum');
            $table->index(['produkt_id', 'erstelldatum']);
            $table->index(['timestamp', 'produkt_id']);
            $table->index(['vertrag_id', 'produkt_id', 'erstelldatum']);
            $table->index(['waehrung_id', 'erstelldatum']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaktion_transaktionen');
    }
};
