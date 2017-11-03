<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precos_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_produto');
            $table->float('preco');
            $table->dateTime('datahora_cadastro');
            $table->timestamps();

            $table->foreign('id_produto', 'precos_produtos_produtos_fk')
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
        Schema::table('precos_produtos', function (Blueprint $table) {
            $table->dropForeign('precos_produtos_produtos_fk');
        });
        Schema::dropIfExists('precos_produtos');
    }
}
