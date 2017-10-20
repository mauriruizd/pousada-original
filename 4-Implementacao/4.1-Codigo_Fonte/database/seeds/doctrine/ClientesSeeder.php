<?php
namespace Database\Seeds\Doctrine;

use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        entity(\App\Entities\Cliente::class, 20)->create();
    }
}
