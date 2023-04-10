<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternationalRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('international_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Nombre del Departamento o Región');
            $table->string('code')->comment('Código especial del Departamento o Región');

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
        Schema::dropIfExists('international_regions');
    }
}
