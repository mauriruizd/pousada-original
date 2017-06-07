<?php

use App\WithEntityManagerInterface;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    use WithEntityManagerInterface;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        entity(\App\Entities\Usuario::class, 20)->create();
    }
}
