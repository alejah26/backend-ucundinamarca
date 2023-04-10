<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conf_lists', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador de tabla');
            $table->string('code')->unique()->comment('Còdigo ùnico de la lista');
            $table->string('name')->comment('Nombre de la lista');
            $table->string('description', 150)->nullable()->comment('Breve descripción de la lista');
            $table->boolean('status')->default(true)->comment('Si la lista esta Activa o No');
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conf_lists');
    }
}
