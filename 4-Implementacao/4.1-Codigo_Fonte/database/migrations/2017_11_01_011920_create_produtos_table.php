<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->unsignedInteger('id_categoria');
            $table->unsignedInteger('id_fornecedor');
            $table->unsignedInteger('estoque_inicial');
            $table->unsignedInteger('estoque_minimo');
            $table->unsignedInteger('estoque');
            $table->string('imagen_url')
                ->nullable()
                ->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_categoria', 'produtos_categorias_fk')
                ->references('id')
                ->on('categorias_produtos');
            $table->foreign('id_fornecedor', 'produtos_fornecedores_fk')
                ->references('id')
                ->on('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function(Blueprint $table) {
            $table->dropForeign('produtos_categorias_fk');
            $table->dropForeign('produtos_fornecedores_fk');
        });
        Schema::dropIfExists('produtos');
    }
}
