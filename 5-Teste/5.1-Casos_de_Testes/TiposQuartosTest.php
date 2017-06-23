<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\TiposQuartosRepository;
use App\Repositories\UserRepository;

class TiposQuartosTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @App\Repositories\TiposQuartosRepository
     */
    protected $tiposQuartos;

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

    protected function setUp()
    {
        parent::setUp();
        $this->tiposQuartos = resolve(TiposQuartosRepository::class);
        $this->usuarios = resolve(UserRepository::class);
    }

    /**
     * Teste de listagem dos tipos de quarto.
     *
     * @return void
     */
    public function testListAllTiposQuartos()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->get('tipos-quartos')
            ->assertResponseOk()
            ->see('Total de 7 Tipos de Quartos');
    }

    /**
     * Teste de edição da tabela de preços
     *
     * @return void
     */
    public function testUpdateTarifas()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->put('tipos-quartos/1/tarifas', [
            'precos[1]' => '123',
            'precos[2]' => '456',
            'precos[3]' => '789',
            'precos[4]' => '123',
            'precos[5]' => '456',
            'precos[6]' => '789',
            'precos[7]' => '123',
            'precos[8]' => '456',
            'precos[9]' => '789',
            'precos[10]' => '123',
            'precos[11]' => '456',
            'precos[12]' => '123'
        ])
            ->followRedirects()
            ->assertResponseOk();
    }

    public function testUpdateTarifasInvalidValue()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->put('tipos-quartos/1/tarifas', [
            'precos[1]' => 'abc',
            'precos[2]' => 'abc',
            'precos[3]' => 'abc',
            'precos[4]' => 'abc',
            'precos[5]' => 'abc',
            'precos[6]' => 'abc',
            'precos[7]' => 'abc',
            'precos[8]' => 'abc',
            'precos[9]' => 'abc',
            'precos[10]' => 'abc',
            'precos[11]' => 'abc',
            'precos[12]' => 'abc'
        ])
            ->followRedirects()
            ->assertSessionHasErrors([
                'precos.*.numeric',
            ]);
    }

    /**
     * Teste de atualização com precos default nas tarifas.
     *
     */
    public function testUpdateTarifasDefaultValue()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->put('tipos-quartos/1/tarifas', [
            'precos[1]' => '',
            'precos[2]' => '',
            'precos[3]' => '',
            'precos[4]' => '',
            'precos[5]' => '',
            'precos[6]' => '',
            'precos[7]' => '',
            'precos[8]' => '',
            'precos[9]' => '',
            'precos[10]' => '',
            'precos[11]' => '',
            'precos[12]' => ''
        ])
            ->followRedirects()
            ->assertResponseOk();
        $tipoQuarto = $this->tiposQuartos->find(1);
        $this->assertEquals($tipoQuarto->getTarifa(1)->getPreco(), 0);
    }

    /**
     * Teste de inicio de promoção.
     */
    public function testStartPromocao()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos(true);
        $this->post('tipos-quartos/1/promocao', [
            'preco' => '30'
        ])
            ->followRedirects()
            ->assertResponseOk();
        $tipo = $this->tiposQuartos->find(1);
        $this->assertEquals(30, $tipo->getPrecoPromocional());
    }

    /**
     * Teste de inicio de promoção com preco promocional maior a tarifa atual.
     */
    public function testStartPromocaoMinorPreco()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos(true);
        $this->post('tipos-quartos/1/promocao', [
            'preco' => '50'
        ])
            ->assertSessionHasErrors([
                'preco'
            ]);
    }

    /**
     * Teste de atualizacao de valor da promoção
     */
    public function testUpdatePromocao()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos(true);
        $this->post('tipos-quartos/1/promocao', [
            'preco' => '30'
        ])
            ->followRedirects()
            ->assertResponseOk();
        $this->put('tipos-quartos/1/promocao', [
            'preco' => '20'
        ])
            ->followRedirects()
            ->assertResponseOk();
    }

    /**
     * Teste de conclusão de promoção
     */
    public function testStopPromocao()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos(true);
        $this->post('tipos-quartos/1/promocao', [
            'preco' => '20'
        ]);
        $this->delete('tipos-quartos/1/promocao')
            ->followRedirects()
            ->assertResponseOk();
    }

    /**
     * Teste de conclusão de promoção não iniciada.
     */
    public function testStopPromocaoNotStarted()
    {
        $this->logAdminIn();
        $this->seedTiposQuartos();
        $this->delete('tipos-quartos/1/promocao')
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
