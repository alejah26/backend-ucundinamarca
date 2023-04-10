<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternationalMunicipalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('international_municipalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Nombre del municipio, provincia o ciudad');
            $table->string('code')->nullable()->comment('Código especial del municipio o provincia');
            $table->boolean('active')->default(true)->comment('Si el muncipio esta activo 1 (True) o No 0 (False)');
            $table->unsignedInteger('region_id')->comment('Llave forenea, Id del país');
            $table->foreign('region_id')->references('id')->on('international_regions');
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
        Schema::dropIfExists('international_municipalities');
    }


}
