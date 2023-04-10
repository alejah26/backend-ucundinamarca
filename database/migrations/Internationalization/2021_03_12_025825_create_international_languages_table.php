<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternationalLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('international_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->char('code', 2);
            $table->char('locale', 5)->nullable();
            $table->string('name', 50);
            $table->string('native_name', 50);
            $table->string('flag')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('international_languages');
    }
}
