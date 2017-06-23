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
     * @var App\Repositories\UserRepository
     */
    protected $usuarios;

    /**
     * @var App\Repositories\ClientesRepository
     */
    protected $clientes;

    protected function setUp()
    {
        parent::setUp();
        $this->clientes = resolve('App\Repositories\ClientesRepository');
        $this->usuarios = resolve('App\Repositories\UserRepository');
    }

    /**
     * Metodo para mockar login de administrador
     *
     * @return void
     */
    protected function logAdminIn()
    {
        $this->seed();
        $this->be($this->usuarios->find(1));
    }

    /**
     * Teste de cadastro de cliente
     *
     * @return void
     */
    public function testClienteCanBeCreated()
    {
        $this->logAdminIn();
        $this->post('clientes', [
            'nome' => 'João Silva',
            'email' => 'joao@teste.com',
            'telefone' => '5544123456',
            'celular' => '5544123456',
            'profissao' => 'Detetive',
            'nacionalidade' => '30',
            'dataNascimento' => '10/02/1980',
            'dni' => '41447479F',
            'cpf' => '41447479F',
            'genero' => 'm',
            'endereco' => 'Av. Brasil 123',
            'cidade' => '9379',
            'observacoes' => 'Nenhuma observação'
        ])
            ->followRedirects()
            ->assertResponseOk();
        $this->assertNotNull($this->clientes->findOneBy([
            'email' => 'joao@teste.com'
        ]));
    }

    public function testErrorCreatingClienteWithoutFields()
    {
        $this->logAdminIn();
        $this->post('clientes', [
            'nome' => 'João Silva',
            'email' => 'joao@teste.com',
            'telefone' => '5544123456',
            'celular' => '5544123456',
            'profissao' => 'Detetive',
            'nacionalidade' => '30',
            'dataNascimento' => '',
            'dni' => '',
            'genero' => '',
            'endereco' => '',
            'cidade' => ''
        ])
            ->assertSessionHasErrors([
                'dataNascimento',
                'dni',
                'cpf',
                'genero',
                'endereco',
                'cidade',
            ]);
    }

    /**
     * Teste de listagem de clientes
     *
     * @return void
     */
    public function testListAllClientes()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $cliente = $this->clientes->find(1);
        $this->visit('clientes')
            ->see($cliente->getNome());
    }

    /**
     * Teste de pesquisa de cliente
     *
     * @return void
     */
    public function testFindCliente()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $cliente = $this->clientes->find(1);
        $this->get('clientes?search=' . $cliente->getEmail())
            ->see($cliente->getNome());
    }

    /**
     * Teste de falha na pesquisa de cliente
     *
     * @return void
     */
    public function testClienteNotFound()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $this->get('clientes?search=' . str_random(50))
            ->see('Total de 0 clientes');
    }

    /**
     * Teste de visualização de detalhes de cliente
     *
     * @return void
     */
    public function testSeeClienteDetails()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $cliente = $this->clientes->find(1);
        $this->get('clientes/1')
            ->see($cliente->getNome());
    }

    public function testShowClienteDetailsNotFound()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $this->get('clientes/100')
            ->assertResponseStatus(404);
    }

    /**
     * Teste de edição de cliente
     *
     * @return void
     */
    public function testEditCliente()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $nomeCliente = $this->clientes->find(1)->getNome();
        $this->put('clientes/1', [
            'nome' => 'João Silva',
            'email' => 'joao@teste.com',
            'telefone' => '5544123456',
            'celular' => '5544123456',
            'profissao' => 'Detetive',
            'nacionalidade' => '30',
            'dataNascimento' => '10/02/1980',
            'dni' => '41447479F',
            'cpf' => '41447479F',
            'genero' => 'm',
            'endereco' => 'Av. Brasil 123',
            'cidade' => '2',
            'observacoes' => 'Nenhuma observação'
        ])
            ->followRedirects()
            ->assertResponseOk();
        $this->assertNotEquals($nomeCliente, $this->clientes->find(1)->getNome());

    }

    /**
     * Teste de eliminação de cliente
     *
     * @return void
     */
    public function testDeleteCliente()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $this->delete('clientes/1')
            ->notSeeInDatabase('clientes', [
                'id' => 1
            ]);
    }

    /**
     * Teste de eliminação de cliente não encontrado
     *
     * @return void
     */
    public function testDeleteClienteNotFound()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $this->delete('clientes/21')
            ->assertResponseStatus(404);
    }

    /**
     * Teste de impresão de ficha de cliente
     *
     * @return void
     */
    public function testPrintFicha()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $this->get('clientes/1/ficha')
            ->seeHeader('Content-Type', 'application/pdf');
    }

    /**
     * Teste de ficha de cliente não encontrado
     *
     * @return void
     */
    public function testErrorFichaClienteNotFound()
    {
        $this->logAdminIn();
        $this->seed('ClientesSeeder');
        $this->get('clientes/21/ficha')
            ->assertResponseStatus(404);
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
