<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentoReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos_reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('datahora');
            $table->float('quantia');
            $table->unsignedInteger('id_reserva');
            $table->timestamps();

            $table->foreign('id_reserva', 'pagamentos_reservas_reservas_fk')
                ->references('id')
                ->on('reservas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagamentos_reservas', function (Blueprint $table) {
            $table->dropForeign('pagamentos_reservas_reservas_fk');
        });
        Schema::dropIfExists('pagamentos_reservas');
    }
}
