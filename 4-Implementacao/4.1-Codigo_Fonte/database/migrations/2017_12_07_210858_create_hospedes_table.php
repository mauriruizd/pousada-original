<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospedes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_estada');
            $table->unsignedInteger('id_cliente');
            $table->timestamps();

            $table->foreign('id_estada', 'hospedes_estadas_fk')
                ->references('id')
                ->on('estadas');
            $table->foreign('id_cliente', 'hospedes_clientes_fk')
                ->references('id')
                ->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospedes', function (Blueprint $table) {
            $table->dropForeign('hospedes_estadas_fk');
            $table->dropForeign('hospedes_clientes_fk');
        });
        Schema::dropIfExists('hospedes');
    }
}
