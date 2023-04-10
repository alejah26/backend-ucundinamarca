<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternationalCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('international_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->char('iso', 2);
            $table->string('name', 80);
            $table->string('nice_name', 80);
            $table->char('iso3', 3)->nullable();
            $table->smallInteger('num_code')->nullable();
            $table->integer('phone_code');
            $table->string('flag')->nullable();
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('international_countries');
    }
}
