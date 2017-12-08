<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Enumeration\EstadoReserva;
use App\Entities\Enumeration\MetodoPagamento;

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
            $table->float('total_comissao')->default(0);
            $table->float('total_comissao_fonte')->default(0);
            $table->float('total_devolvido_cancelamento')->default(0);
            $table->boolean('comissao_paga')->default(false);
            $table->enum('estado', [
                EstadoReserva::$ABERTA,
                EstadoReserva::$CONFIRMADA,
                EstadoReserva::$CANCELADA
            ])->default(EstadoReserva::$ABERTA);
            $table->unsignedInteger('id_quarto');
            $table->unsignedInteger('id_comissionista')->nullable()->default(null);
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_cliente_reservante');
            $table->unsignedInteger('id_fonte');
            $table->enum('tipo_pagamento', [
                MetodoPagamento::$PARCELADO,
                MetodoPagamento::$AVISTA
            ]);
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
            $table->foreign('id_cliente_reservante', 'reservas_clientes_fk')
                ->references('id')
                ->on('clientes');
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
            $table->dropForeign('reservas_clientes_fk');
            $table->dropForeign('reservas_fontes_reservas_fk');
        });
        Schema::dropIfExists('reservas');
    }
}
