<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaixasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caixas', function (Blueprint $table) {
            $table->increments('id');
            $table->float('quantidade_inicial');
            $table->dateTime('datahora_apertura');
            $table->dateTime('datahora_fechamento')->nullable()->default(null);
            $table->float('valor_total')->default(0);
            $table->unsignedInteger('id_usuario');
            $table->timestamps();

            $table->foreign('id_usuario', 'caixas_usuarios_fk')
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
        Schema::table('caixas', function (Blueprint $table) {
            $table->dropForeign('caixas_usuarios_fk');
        });
        Schema::dropIfExists('caixas');
    }
}
