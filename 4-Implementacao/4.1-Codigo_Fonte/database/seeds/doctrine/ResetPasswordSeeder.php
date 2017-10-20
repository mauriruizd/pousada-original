<?php
namespace Database\Seeds\Doctrine;

use App\WithEntityManagerInterface;
use Illuminate\Database\Seeder;

class ResetPasswordSeeder extends Seeder
{
    use WithEntityManagerInterface;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pr = new \App\Entities\PasswordReset();
        $pr->setEmail('admin@admin.com');
        $pr->setToken('token');
        $this->em->persist($pr);
        $this->em->flush();
    }
}
