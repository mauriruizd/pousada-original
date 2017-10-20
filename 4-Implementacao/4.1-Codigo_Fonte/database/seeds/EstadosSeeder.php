<?php

use Illuminate\Database\Seeder;

class EstadosSeeder extends GeographicDataSeeder
{
    /**
     * Chaves para inserção desde metodo fill.
     *
     * @var array
     */
    protected $keys = [
        'id',
        'nome',
        'id_pais'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fill('estados', file_get_contents('database/seeds/txtdumps/estados.txt'));
    }
}
