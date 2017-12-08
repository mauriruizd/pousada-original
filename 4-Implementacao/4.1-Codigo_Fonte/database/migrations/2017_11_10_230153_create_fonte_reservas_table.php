<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFonteReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fontes_reservas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->boolean('pagamento_vista')->default(false);
            $table->boolean('pagamento_parcelado')->default(false);
            $table->float('percentagem_vista')->default(0);
            $table->float('percentagem_parcelado')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fontes_reservas');
    }
}
