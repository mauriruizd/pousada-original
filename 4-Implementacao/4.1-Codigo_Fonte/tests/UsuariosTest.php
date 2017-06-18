<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Contracts\Console\Kernel;

use App\Entities\Usuario;
use App\Entities\Enumeration\TipoUsuario;

class UsuariosTest extends TestCase
{
    protected $usuarios;

    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->usuarios = resolve('App\Repositories\UserRepository');
    }

    public function testCanDoLogin()
    {
        $this->seed('AdminUsersSeeder');
        $this->post('login', [
            'email' => 'admin@admin.com',
            'password' => 'admin123',
        ])
            ->seeIsAuthenticated();
    }

    public function testLoginFailPasswordEmpty()
    {
        $this->seed('AdminUsersSeeder');
        $this->post('login', [
            'email' => 'admin@admin.com',
        ])
            ->assertSessionHasErrors('password');
    }

    public function testLoginFailPasswordIncorrect()
    {
        $this->seed('AdminUsersSeeder');
        $this->post('login', [
            'email' => 'admin@admin.com',
            'password' => 'fakepassword'
        ])
            ->assertSessionHasErrors('email');
    }

    public function testResetPasswordByEmail()
    {
        $this->seed('AdminUsersSeeder');
        $this->post('password/email', [
            'email' => 'admin'
        ])
            ->followRedirects()
            ->assertResponseOk();
    }

    public function testResetPasswordWithToken()
    {
        $this->seed('AdminUsersSeeder');
        $this->seed('ResetPasswordSeeder');
        $this->post('password/reset', [
            'token' => 'token',
            'email' => 'admin@admin.com',
            'password' => 'newpass',
            'password_confirmation' => 'newpass'
        ]);
        $this->post('login', [
            'email' => 'admin@admin.com',
            'password' => 'newpass'
        ])
            ->isAuthenticated();
    }

    public function testShowAllUsuarios()
    {
        $this->logAdminIn();
        $this->seed('UsuariosSeeder');
        $this->visit('usuarios')
            ->see('Total de 21 usuários');
    }

    public function testShowUsuarioDetails()
    {
        $this->logAdminIn();
        $this->seed('UsuariosSeeder');
        $user = $this->usuarios->find(15);
        $this->visit('usuarios/15')
            ->see($user->getNome());
    }

    public function testShowUsuarioDetailsNotFound()
    {
        $this->logAdminIn();
        $this->seed('UsuariosSeeder');
        $this->get('usuarios/100')
            ->assertResponseStatus(404);
    }

    public function testsEditUsuario()
    {
        $this->logAdminIn();
        $this->seed('UsuariosSeeder');
        $user = $this->usuarios->find(1);
        $newName = 'Pão com queijo';
        $this->put('usuarios/1', [
            'nome' => $newName
        ])
            ->visit('usuarios/1')
            ->dontSee('Nome: ' . $user->getNome());
    }

    public function testEditUsuarioEmptyFields()
    {
        $this->logAdminIn();
        $this->seed('UsuariosSeeder');
        $this->put('usuarios/1', [
            'nome' => '',
            'email' => ''
        ])
            ->assertSessionHasErrors([
                'nome',
                'email'
            ]);
    }

    public function testCreateUsuario()
    {
        $this->logAdminIn();
        $this->post('usuarios', [
            'nome' => 'Alexandre Pires',
            'email' => 'alexandrepires@pires.com',
            'tipo' => TipoUsuario::$RECEPCIONISTA,
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $this->seeInDatabase('usuarios', [
            'email' => 'alexandrepires@pires.com'
        ]);
    }

    public function testCreateUsuarioPasswordConfirmationMismatch()
    {
        $this->logAdminIn();
        $this->post('usuarios', [
            'nome' => 'Alexandre Pires',
            'email' => 'alexandrepires@pires.com',
            'tipo' => TipoUsuario::$RECEPCIONISTA,
            'password' => '123456',
            'password_confirmation' => 'pires'
        ])
            ->assertSessionHasErrors('password');
    }

    public function testCreateUsuarioForbiddenUser()
    {
        $this->seed('AdminUsersSeeder');
        $this->seed('UsuariosSeeder');
        $this->be($this->usuarios->findOneBy(['tipo' => TipoUsuario::$RECEPCIONISTA]));
        $this->post('usuarios', [
            'nome' => 'Alexandre Pires',
            'email' => 'alexandrepires@pires.com',
            'tipo' => TipoUsuario::$RECEPCIONISTA,
            'password' => '123456',
            'password_confirmation' => '123456'
        ])
            ->assertResponseStatus('403');
    }

    public function testDeleteUsuario()
    {
        $this->logAdminIn();
        $this->seed('UsuariosSeeder');
        $this->delete('usuarios/3');
        $this->get('usuarios/3')
            ->followRedirects();
    }

    public function testDeleteAuthenticatedUsuarioForbidden()
    {
        $this->seed('AdminUsersSeeder');
        $this->be($this->usuarios->find(1));
        $this->delete('usuarios/1')
            ->assertResponseStatus('403');
    }

    public function runDatabaseMigrations()
    {
        $this->artisan('doctrine:migrations:migrate');

        $this->app[Kernel::class]->setArtisan(null);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('doctrine:migrations:reset');
        });
    }

    private function logAdminIn()
    {
        $this->seed('AdminUsersSeeder');
        $this->be($this->usuarios->find(1));
    }

}
