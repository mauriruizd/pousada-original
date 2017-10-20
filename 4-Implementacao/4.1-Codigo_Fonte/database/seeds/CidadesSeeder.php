<?php

use Illuminate\Database\Seeder;

class CidadesSeeder extends GeographicDataSeeder
{
    /**
     * Chaves para inserção desde metodo fill.
     *
     * @var array
     */
    protected $keys = [
        'id',
        'nome',
        'id_estado'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fill('cidades', file_get_contents('database/seeds/txtdumps/cidades.txt'));
    }
}
