<?php

use Illuminate\Database\Seeder;
use App\Entities\Estado;
use App\Entities\Pais;

use App\WithEntityManagerInterface;

class EstadosSeeder extends Seeder
{
    use WithEntityManagerInterface;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = file_get_contents('database/seeds/estados.txt');
        foreach (explode("\n", $estados) as $registro) {
            $partes = explode(",", $registro);
            $estado = new Estado();
            $estado->setId($partes[0]);
            $estado->setNome($partes[1]);
            $estado->setPais($this->em->getRepository('App\Entities\Pais')->find($partes[2]));
            $this->em->persist($estado);
        }
        $this->em->flush();
    }
}
