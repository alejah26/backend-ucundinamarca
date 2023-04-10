<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfListDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conf_list_details', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador de tabla');
            $table->unsignedInteger('list_id')->comment('Llave forenea, Id de la lista principal');
            $table->string('name')->comment('Nombre del detalle de la lista');
            $table->string('code')->unique()->comment('Código del detalle de la lista');
            $table->boolean('status')->comment('Estado del detalle de la lista');
            $table->foreign('list_id')->references('id')->on('conf_lists');
            $table->boolean('favourite')->nullable()->comment('Indica el elemento por defecto o favorito');
            $table->json('metadata')->nullable()->comment('Metadatos Json adicionales del elemento');
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
        Schema::table('conf_list_details', function ($table) {
            $table->dropForeign(['list_id']);
        });

        Schema::dropIfExists('conf_list_details');
    }
}