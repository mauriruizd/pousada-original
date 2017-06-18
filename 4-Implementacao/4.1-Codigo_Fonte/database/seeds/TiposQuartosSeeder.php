<?php

use Illuminate\Database\Seeder;
use App\Repositories\TiposQuartosRepository;
use App\Entities\TipoQuarto;
class TiposQuartosSeeder extends Seeder
{
    /**
     * @App\Repositories\DoctrineTiposQuartosRepository
     */
    private $tiposQuartos;

    public function __construct(TiposQuartosRepository $tiposQuartos)
    {
        $this->tiposQuartos = $tiposQuartos;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nomesTipos = [
            ['Solteiro', 1],
            ['Solteiro Duplo', 2],
            ['Casal (camas separadas)', 2],
            ['Casal (cama casal)', 2],
            ['Triplo', 3],
            ['Quadruplo', 4],
            ['Quintuplo', 5]
        ];
        $tipos = array_map(function($dadosTipoQuarto) {
            return $this->tiposQuartos->create([
                'nome' => $dadosTipoQuarto[0],
                'capacidade' => $dadosTipoQuarto[1]
            ]);
        }, $nomesTipos);
        $this->tiposQuartos->saveMany($tipos);
    }
}
