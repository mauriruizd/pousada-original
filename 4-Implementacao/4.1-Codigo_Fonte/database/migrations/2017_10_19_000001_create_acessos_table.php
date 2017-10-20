<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acessos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->dateTime('timestamp')->default(new \Carbon\Carbon());

            $table->foreign('id_usuario', 'acessos_usuarios_fk')
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
        Schema::table('acessos', function(Blueprint $table) {
            $table->dropForeign('acessos_usuarios_fk');
        });
        Schema::dropIfExists('acessos');
    }
}
