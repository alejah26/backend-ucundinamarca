<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternationalCurrencyCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('international_currency_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency', 60 )->comment('Nombre oficial de la moneda.');
            $table->char('code', 3)->comment('Código de la Moneda.');
            $table->string('symbol',  1)->nullable()->comment('Símbolo de la moneda. Ej: $');

            $table->unsignedInteger('country_id')->comment('Llave forenea, Id del país');
            $table->foreign('country_id')->references('id')->on('international_countries');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('international_currency_countries');
    }
}
