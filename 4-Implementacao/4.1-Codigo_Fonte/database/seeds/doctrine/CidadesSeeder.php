<?php

namespace Database\Seeds\Doctrine;

use Illuminate\Database\Seeder;
use App\Entities\Cidade;

use App\WithEntityManagerInterface;

class CidadesSeeder extends Seeder
{
    use WithEntityManagerInterface;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cidades = file_get_contents('database/seeds/cidades.txt');
        foreach (explode("\n", $cidades) as $registro) {
            $partes = explode(",", $registro);
            $cidade = new Cidade();
            $cidade->setId($partes[0]);
            $cidade->setNome($partes[1]);
            $cidade->setEstado($this->em->getRepository('App\Entities\Estado')->find($partes[2]));
            $this->em->persist($cidade);
        }
        $this->em->flush();
    }
}
