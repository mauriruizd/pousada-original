<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_entrada');
            $table->date('data_saida');
            $table->float('valor_total');
            $table->boolean('comissao_paga')->default(false);
            $table->unsignedInteger('id_quarto');
            $table->unsignedInteger('id_comissionista')->nullable()->default(null);
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_fonte');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_quarto', 'reservas_quartos_fk')
                ->references('id')
                ->on('quartos');
            $table->foreign('id_comissionista', 'reservas_comissionistas_fk')
                ->references('id')
                ->on('comissionistas');
            $table->foreign('id_usuario', 'reservas_usuarios_fk')
                ->references('id')
                ->on('usuarios');
            $table->foreign('id_fonte', 'reservas_fontes_reservas_fk')
                ->references('id')
                ->on('fontes_reservas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign('reservas_quartos_fk');
            $table->dropForeign('reservas_comissionistas_fk');
            $table->dropForeign('reservas_usuarios_fk');
            $table->dropForeign('reservas_fontes_reservas_fk');
        });
        Schema::dropIfExists('reservas');
    }
}