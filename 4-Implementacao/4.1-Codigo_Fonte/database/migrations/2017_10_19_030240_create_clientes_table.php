<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->string('celular');
            $table->string('profissao');
            $table->unsignedInteger('id_nacionalidade');
            $table->date('data_nascimento');
            $table->string('rg');
            $table->string('cpf');
            $table->char('sexo');
            $table->string('endereco');
            $table->unsignedInteger('id_cidade');
            $table->text('observacoes');
            $table->unsignedInteger('id_usuario');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_nacionalidade', 'clientes_paises_fk')
                ->references('id')
                ->on('paises');

            $table->foreign('id_cidade', 'clientes_cidades_fk')
                ->references('id')
                ->on('cidades');

            $table->foreign('id_usuario', 'clientes_usuarios_fk')
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
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign('clientes_paises_fk');
            $table->dropForeign('clientes_cidades_fk');
            $table->dropForeign('clientes_usuarios_fk');
        });
        Schema::dropIfExists('clientes');
    }
}
