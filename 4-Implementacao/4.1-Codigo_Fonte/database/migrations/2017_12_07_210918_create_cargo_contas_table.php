<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargoContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos_contas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_estada');
            $table->unsignedInteger('id_usuario');
            $table->float('valor');
            $table->string('motivo');
            $table->timestamps();

            $table->foreign('id_estada', 'cargos_contas_estadas_fk')
                ->references('id')
                ->on('estadas');

            $table->foreign('id_usuario', 'cargos_contas_usuarios_fk')
                ->references('id')
                ->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cargos_contas', function (Blueprint $table) {
            $table->dropForeign('cargos_contas_estadas_fk');
            $table->dropForeign('cargos_contas_usuarios_fk');
        });
        Schema::dropIfExists('cargos_contas');
    }
}
