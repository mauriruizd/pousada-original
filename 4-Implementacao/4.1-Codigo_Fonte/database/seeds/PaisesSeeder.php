<?php

use Illuminate\Database\Seeder;

class PaisesSeeder extends GeographicDataSeeder
{
    /**
     * Chaves para inserção desde metodo fill.
     *
     * @var array
     */
    protected $keys = [
        'id',
        'nome'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fill('paises', file_get_contents('database/seeds/txtdumps/paises.txt'));
    }
}
