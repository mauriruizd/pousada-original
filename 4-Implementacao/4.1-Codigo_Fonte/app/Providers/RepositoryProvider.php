<?php

namespace App\Providers;

use App\Entities\Usuario;
use App\Repositories\DoctrineUserRepository;
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
        $this->app->bind(UserRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new DoctrineUserRepository(
                $app['em'],
                $app['em']->getClassMetaData(Usuario::class)
            );
        });
    }
}
