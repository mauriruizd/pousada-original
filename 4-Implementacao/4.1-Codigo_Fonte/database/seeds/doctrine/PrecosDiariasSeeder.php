<?php
namespace Database\Seeds\Doctrine;

use Illuminate\Database\Seeder;

class PrecosDiariasSeeder extends Seeder
{
    protected $tiposQuartos;
    public function __construct(\App\Repositories\TiposQuartosRepository $tiposQuartos)
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
        $tiposQuartos = $this->tiposQuartos->findAll();
        foreach ($tiposQuartos as $tipoQuarto) {
            for ($i = 1; $i <= 12; $i++) {
                $tipoQuarto->setTarifa($i, 40);
            }
        }
        $this->tiposQuartos->saveMany($tiposQuartos);
    }
}
