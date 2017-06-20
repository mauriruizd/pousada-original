<?php

use Illuminate\Database\Seeder;

class QuartosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        entity(\App\Entities\Quarto::class, 30)->create();
    }
}
