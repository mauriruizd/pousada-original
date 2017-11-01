<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoQuartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos_quartos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_quarto');
            $table->string('url');
            $table->timestamps();

            $table->foreign('id_quarto', 'fotos_quartos_quartos_fk')
                ->references('id')
                ->on('quartos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fotos_quartos', function (Blueprint $table) {
            $table->dropForeign('fotos_quartos_quartos_fk');
        });
        Schema::dropIfExists('fotos_quartos');
    }
}
