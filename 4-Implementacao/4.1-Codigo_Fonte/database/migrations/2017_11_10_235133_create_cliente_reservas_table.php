<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_reserva');
            $table->unsignedInteger('id_cliente');
            $table->timestamps();

            $table->foreign('id_reserva', 'clientes_reservas_reservas_fk')
                ->references('id')
                ->on('reservas');
            $table->foreign('id_cliente', 'clientes_reservas_clientes_fk')
                ->references('id')
                ->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes_reservas', function (Blueprint $table) {
            $table->dropForeign('clientes_reservas_reservas_fk');
            $table->dropForeign('clientes_reservas_clientes_fk');
        });
        Schema::dropIfExists('clientes_reservas');
    }
}
