<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Enumeration\TipoMovimento;
class CreateMovimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->float('valor');
            $table->text('motivo');
            $table->enum('tipo', [
                TipoMovimento::$ENTRADA,
                TipoMovimento::$SAIDA
            ]);
            $table->unsignedInteger('id_caixa');
            $table->unsignedInteger('id_cargo_conta')->nullable()->default(null);
            $table->unsignedInteger('id_pagamento_conta')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('id_caixa', 'movimentos_caixas')
                ->references('id')
                ->on('caixas');

            $table->foreign('id_cargo_conta', 'movimentos_cargos_contas')
                ->references('id')
                ->on('cargos_contas');

            $table->foreign('id_pagamento_conta', 'movimentos_pagamentos_contas')
                ->references('id')
                ->on('pagamento_contas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimentos', function (Blueprint $table) {
            $table->dropForeign('movimentos_cargos_contas');
            $table->dropForeign('movimentos_pagamentos_contas');
        });
        Schema::dropIfExists('movimentos');
    }
}
