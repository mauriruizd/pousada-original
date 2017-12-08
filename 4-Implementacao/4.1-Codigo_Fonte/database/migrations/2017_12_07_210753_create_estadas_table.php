<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadas', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('datahora_entrada');
            $table->dateTime('datahora_saida')->nullable()->default(null);
            $table->unsignedTinyInteger('nro_dias');
            $table->float('valor_total');
            $table->unsignedInteger('id_reserva');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_quarto');
            $table->timestamps();

            $table->foreign('id_reserva', 'estadas_reservas_fk')
                ->references('id')
                ->on('reservas');
            $table->foreign('id_usuario', 'estadas_usuarios_fk')
                ->references('id')
                ->on('usuarios');

            $table->foreign('id_quarto', 'estadas_quartos_fk')
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
        Schema::table('estadas', function (Blueprint $table) {
            $table->dropForeign('estadas_reservas_fk');
            $table->dropForeign('estadas_usuarios_fk');
            $table->dropForeign('estadas_quartos_fk');
        });
        Schema::dropIfExists('estadas');
    }
}
