<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumicaoFrigobarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumicoes_frigobar', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cargo_conta');
            $table->unsignedInteger('id_produto');
            $table->float('preco');
            $table->integer('quantidade');
            $table->float('subtotal');
            $table->timestamps();

            $table->foreign('id_cargo_conta', 'consumicoes_frigobar_cargos_contas_fk')
                ->references('id')
                ->on('cargos_contas');
            $table->foreign('id_produto', 'consumicoes_frigobar_produtos_fk')
                ->references('id')
                ->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumicoes_frigobar', function (Blueprint $table) {
            $table->dropForeign('consumicoes_frigobar_cargos_contas_fk');
            $table->dropForeign('consumicoes_frigobar_produtos_fk');
        });
        Schema::dropIfExists('consumicoes_frigobar');
    }
}
