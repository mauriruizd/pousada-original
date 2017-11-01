<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManutencaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manutencoes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_quarto');
            $table->date('data_inicio');
            $table->date('data_fim')
                ->nullable()
                ->default(null);
            $table->text('motivo');
            $table->timestamps();

            $table->foreign('id_quarto', 'manutencoes_quartos_fk')
                ->references('id')
                ->on('quartos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manutencoes', function (Blueprint $table) {
            $table->dropForeign('manutencoes_quartos_fk');
        });
        Schema::dropIfExists('manutencoes');
    }
}
