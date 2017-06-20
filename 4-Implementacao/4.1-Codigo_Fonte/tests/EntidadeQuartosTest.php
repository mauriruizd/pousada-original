<?php

use App\Repositories\QuartosRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EntidadeQuartosTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @App\Repositories\QuartosRepository
     */
    protected $quartos;

    /**
     * @App\Repositories\UserRepository
     */
    protected $usuarios;

    /**
     * Metodo para mockar login de administrador
     *
     * @return void
     */
    protected function logAdminIn()
    {
        $this->seed(AdminUsersSeeder::class);
        $this->be($this->usuarios->find(1));
    }

    /**
     * Método para carregar tipos de quartos no BD.
     *
     * @param boolean $withTarifas
     * @return void
     */
    protected function seedTiposQuartos($withTarifas = false)
    {
        $this->seed('TiposQuartosSeeder');
        if ($withTarifas) {
            $this->seed(PrecosDiariasSeeder::class);
        }
    }

    /**
     * Método para carregar quartos no BD.
     *
     * @return void
     */
    protected function seedQuartos()
    {
        $this->seed(QuartosSeeder::class);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->quartos = resolve(QuartosRepository::class);
        $this->usuarios = resolve(UserRepository::class);
    }

    /**
     * Teste de listado de todos os quartos.
     */
    public function testAllQuartos()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $this->get('quartos')
            ->see('Total de 30 quartos.');
    }

    /**
     * Teste de pesquisa de quarto por numero.
     */
    public function testSearchQuarto()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $quarto = $this->quartos->find(1);
        $this->get('quartos?search=' . $quarto->getNumero())
            ->assertResponseOk()
            ->see($quarto->getNumero());
    }

    /**
     * Teste de criação de quarto.
     */
    public function testCreateQuarto()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->post('quartos', [
            'numero' => '1A',
            'andar' => '1',
            'tipo_quarto' => '1',
        ])
            ->assertResponseOk();
    }

    /**
     * Teste de criação de quarto sem numero.
     */
    public function testCreateQuartoWithoutNumero()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->post('quartos', [
            'numero' => '',
            'andar' => '1',
            'tipo_quarto' => '1',
        ])
            ->assertSessionHasErrors([
                'numero'
            ]);
    }

    /**
     * Teste de criação de quarto com andar não existente.
     */
    public function testCreateQuartoNotAndarNotExistent()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->post('quartos', [
            'numero' => '1A',
            'andar' => '4',
            'tipo_quarto' => '1',
        ])
            ->assertSessionHasErrors([
                'andar'
            ]);
    }

    /**
     * Teste de detalhes de quarto.
     */
    public function testQuartoDetails()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $quarto = $this->quartos->find(1);
        $this->get('quartos/1')
            ->assertResponseOk()
            ->see($quarto->getNumero());
    }

    /**
     * Teste de detalhes de quarto não encontrado.
     */
    public function testQuartoDetailsNotFound()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $this->get('quartos/100')
            ->assertResponseStatus(404);
    }

    /**
     * Teste de edição de quarto.
     */
    public function testEditQuarto()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $quarto = $this->quartos->find(1);
        $newTipo = $quarto->getTipoQuarto()->getId() === 1 ? 2 : 1;
        $this->put('quartos/1', [
            'id_tipo_quarto' => $newTipo
        ])
            ->assertResponseOk();
        $this->assertEquals($newTipo, $this->quartos->find(1)->getTipoQuarto()->getId());
    }

    /**
     * Teste de inicio de manutenção
     */
    public function testStartManutencao()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $this->post('quartos/1/manutencao', [
            'motivo' => str_random(50)
        ])
            ->assertResponseOk();
    }

    /**
     * Teste de manutenção de quarto não encontrado.
     */
    public function testStartManutencaoQuartoNotFound()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $this->post('quartos/100/manutencao', [
            'motivo' => str_random(50)
        ])
            ->assertResponseStatus(404);
    }

    /**
     * Teste de manutenção de quarto já começado.
     */
    public function testStartManutencaoAlreadyStarted()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $quarto = $this->quartos->find(1);
        $quarto->setEmManutencao(true);
        $this->quartos->save($quarto);
        $this->post('quartos/1/manutencao', [
            'motivo' => str_random(50)
        ])
            ->assertResponseStatus(403);
    }

    /**
     * Teste de finalização de manutenção.
     */
    public function testEndManutencao()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $quarto = $this->quartos->find(1);
        $quarto->setEmManutencao(true);
        $this->quartos->save($quarto);
        $this->delete('quartos/1/manutencao')
            ->assertResponseOk();
    }

    /**
     * Teste de finalização de manutenção não começada
     */
    public function testEndManutencaoNotStarted()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->seedQuartos();
        $this->delete('quartos/1/manutencao')
            ->assertResponseStatus(403);
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
