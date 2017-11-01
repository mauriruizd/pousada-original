<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quartos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->tinyInteger('andar');
            $table->unsignedInteger('id_tipo_quarto');
            $table->boolean('em_manutencao')
                ->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_tipo_quarto', 'quartos_tipos_quartos_fk')
                ->references('id')
                ->on('tipos_quartos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quartos', function (Blueprint $table) {
            $table->dropForeign('quartos_tipos_quartos_fk');
        });
        Schema::dropIfExists('quartos');
    }
}
