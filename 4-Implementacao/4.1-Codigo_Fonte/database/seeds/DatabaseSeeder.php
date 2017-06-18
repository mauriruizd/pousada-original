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
        $this->call(AdminUsersSeeder::class);
        $this->call(PaisesSeeder::class);
        $this->call(EstadosSeeder::class);
        $this->call(CidadesSeeder::class);
        $this->call(TiposQuartosSeeder::class);
    }
}
