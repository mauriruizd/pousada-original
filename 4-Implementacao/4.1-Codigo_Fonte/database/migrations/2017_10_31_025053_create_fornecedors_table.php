<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cnpj');
            $table->string('cep')->nullable()->default(null);
            $table->string('endereco')->nullable()->default(null);
            $table->string('numero')->nullable()->default(null);
            $table->string('complemento')->nullable()->default(null);
            $table->unsignedInteger('id_cidade')
                ->nullable()
                ->default(null);
            $table->string('fone')
                ->nullable()
                ->default(null);
            $table->string('email')
                ->nullable()
                ->default(null);
            $table->string('site')
                ->nullable()
                ->default(null);
            $table->string('nome_encarregado')
                ->nullable()
                ->default(null);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_cidade', 'fornecedores_cidades_fk')
                ->references('id')
                ->on('cidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->dropForeign('fornecedores_cidades_fk');
        });
        Schema::dropIfExists('fornecedores');
    }
}
