<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComissionistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissionistas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('telefone')->nullable()->default(null);
            $table->float('percentagem');
            $table->unsignedInteger('id_categoria');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_categoria', 'comissionistas_categorias_fk')
                ->references('id')
                ->on('categorias_comissionistas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comissionistas', function(Blueprint $table) {
            $table->dropForeign('comissionistas_categorias_fk');
        });
        Schema::dropIfExists('comissionistas');
    }
}
