<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->unsignedInteger('id_pais');
            $table->timestamps();

            $table->foreign('id_pais', 'estados_paises_fk')
                ->references('id')
                ->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estados', function(Blueprint $table) {
            $table->dropForeign('estados_paises_fk');
        });
        Schema::dropIfExists('estados');
    }
}
