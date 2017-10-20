<?php
namespace Database\Seeds\Doctrine;

use Illuminate\Database\Seeder;

use App\Entities\Usuario;
use App\Entities\Enumeration\TipoUsuario;

use App\WithEntityManagerInterface;

class AdminUsersSeeder extends Seeder
{
    use WithEntityManagerInterface;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Usuario();
        $admin->setNome('Admministrador');
        $admin->setEmail('admin@admin.com');
        $admin->setPassword('admin123');
        $admin->setTipo(TipoUsuario::$ADMINISTRADOR);
        $this->em->persist($admin);
        $this->em->flush();
    }
}
