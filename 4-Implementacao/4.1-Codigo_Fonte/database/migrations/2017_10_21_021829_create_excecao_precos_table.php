<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcecaoPrecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excecoes_precos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tipo_quarto');
            $table->float('preco');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_tipo_quarto', 'excecoes_precos_tipos_quartos_fk')
                ->references('id')
                ->on('tipos_quartos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('excecoes_precos', function(Blueprint $table) {
            $table->dropForeign('excecoes_precos_tipos_quartos_fk');
        });
        Schema::dropIfExists('excecoes_precos');
    }
}
