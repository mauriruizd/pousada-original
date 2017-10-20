<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuariosAdministradoresSeeder::class);
        $this->call(PaisesSeeder::class);
        $this->call(EstadosSeeder::class);
        $this->call(CidadesSeeder::class);
    }
}
