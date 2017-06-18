<?php

namespace App\Providers;

use App\Entities\Cliente;
use App\Entities\TipoQuarto;
use App\Entities\Usuario;
use App\Repositories\ClientesRepository;
use App\Repositories\DoctrineClientesRepository;
use App\Repositories\DoctrineTiposQuartosRepository;
use App\Repositories\DoctrineUserRepository;
use App\Repositories\TiposQuartosRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Users Repo
        $this->app->bind(UserRepository::class, function($app) {
            return new DoctrineUserRepository(
                $app['em'],
                $app['em']->getClassMetaData(Usuario::class)
            );
        });

        // Clientes Repo
        $this->app->bind(ClientesRepository::class, function($app) {
            return new DoctrineClientesRepository(
                $app['em'],
                $app['em']->getClassMetaData(Cliente::class)
            );
        });

        // Tipos de Quartos Repo
        $this->app->bind(TiposQuartosRepository::class, function($app) {
            return new DoctrineTiposQuartosRepository(
                $app['em'],
                $app['em']->getClassMetaData(TipoQuarto::class)
            );
        });
    }
}
