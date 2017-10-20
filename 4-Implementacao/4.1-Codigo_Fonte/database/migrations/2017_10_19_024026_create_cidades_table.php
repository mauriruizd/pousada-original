<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->unsignedInteger('id_estado');
            $table->timestamps();

            $table->foreign('id_estado', 'cidades_estados_fk')
                ->references('id')
                ->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cidades', function(Blueprint $table) {
            $table->dropForeign('cidades_estados_fk');
        });
        Schema::dropIfExists('cidades');
    }
}
