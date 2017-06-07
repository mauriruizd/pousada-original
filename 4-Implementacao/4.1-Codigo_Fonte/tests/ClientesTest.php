<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Contracts\Console\Kernel;

use App\Entities\Usuario;

class ClientesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Metodo para mockar login
     *
     * @return void
     */
    protected function loginWithFakeUser()
    {
        $user = new Usuario('Admin', 'admin');
        $this->be($user);
    }

    /**
     * Teste de cadastro de cliente
     *
     * @return void
     */
    public function testClienteCanBeCreated()
    {
        $this->loginWithFakeUser();
        $this->visit('clientes/create')
            ->submitForm('Cadastrar Cliente', [
                'nome' => 'João Silva',
                'email' => 'joao@teste.com',
                'telefone' => '5544123456',
                'celular' => '5544123456',
                'profissao' => 'Detetive',
                'nacionalidade' => 'br',
                'data_nascimento' => '10/02/1980',
                'dni' => '41447479F',
                'cpf' => '41447479F',
                'genero' => 'm',
                'pais' => 'BR',
                'estado' => 'PR',
                'cidade' => 'FOZ',
                'observacoes' => 'Nenhuma observação'
            ])
            ->seePageIs('clientes')
            ->see('Cliente cadastrado com sucesso!');
    }

    /**
     * Teste de listagem de clientes
     *
     * @return void
     */
    public function testListAllClientes()
    {
        $this->loginWithFakeUser();
        $this->visit('clientes')
            ->see('João Silva');
    }

    /**
     * Teste de pesquisa de cliente
     *
     * @return void
     */
    public function testFindCliente()
    {
        $this->loginWithFakeUser();
        $this->visit('clientes')
            ->type('41447479F', '#dni')
            ->press('Pesquisar')
            ->see('Clientes encontrados com dni "41447479F"')
            ->see('João Silva');
    }

    /**
     * Teste de falha na pesquisa de cliente
     *
     * @return void
     */
    public function testNotFindCliente()
    {
        $this->loginWithFakeUser();
        $this->visit('clientes')
            ->type('123', '#dni')
            ->press('Pesquisar')
            ->notSee('João Silva');
    }

    /**
     * Teste de visualização de detalhes de cliente
     *
     * @return void
     */
    public function testSeeClienteDetails()
    {
        $this->loginWithFakeUser();
        $this->visit('clientes')
            ->click('<i class="fa fa-eye"></i>')
            ->seePageIs('clientes/1')
            ->see('João Silva')
            ->see('joao@teste.com');
    }

    /**
     * Teste de edição de cliente
     *
     * @return void
     */
    public function testEditCliente()
    {
        $this->loginWithFakeUser();
        $this->loginWithFakeUser();
        $this->visit('clientes')
            ->click('<i class="fa fa-pencil"></i>')
            ->seePageIs('clientes/1/edit')
            ->type('Claudia Leitte', '#nome')
            ->press('Editar Cliente')
            ->seePageIs('clientes')
            ->see('Cliente editado com sucesso!');
    }

    /**
     * Teste de cancelacão de eliminação de cliente
     *
     * @return void
     */
    public function testCancelDeleteCliente()
    {
        $this->loginWithFakeUser();
        $this->visit('clientes')
            ->click('<i class="fa fa-trash"></i>')
            ->see('Confirma que deseja eliminar o cliente "Claudia Leitte"?')
            ->click('Não')
            ->seePageIs('clientes')
            ->see('Claudia Leitte');
    }

    /**
     * Teste de eliminação de cliente
     *
     * @return void
     */
    public function testDeleteCliente()
    {
        $this->loginWithFakeUser();
        $this->visit('clientes')
            ->click('<i class="fa fa-trash"></i>')
            ->see('Confirma que deseja eliminar o cliente "Claudia Leitte"?')
            ->click('Sim')
            ->seePageIs('clientes')
            ->see('Cliente eliminado com sucesso!')
            ->notSee('Claudia Leitte');
    }

    public function runDatabaseMigrations()
    {
        $this->artisan('doctrine:migrations:migrate');

        $this->app[Kernel::class]->setArtisan(null);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('doctrine:migrations:reset');
        });
    }
}
