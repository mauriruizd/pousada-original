<?php

use Illuminate\Database\Seeder;
use App\Entities\Usuario;

class UsuariosAdministradoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'nome' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => 'admin123',
            'tipo' => \App\Entities\Enumeration\TipoUsuario::$ADMINISTRADOR
        ]);
    }
}
