<?php
namespace App\Foundation;

class Application extends \Illuminate\Foundation\Application
{
    /**
     * Para uso nos casos de teste para diminuir uso de memória
     */
    public function clean()
    {
        unset($this->bootingCallbacks);
        unset($this->bootedCallbacks);
        unset($this->finishCallbacks);
        unset($this->shutdownCallbacks);
        unset($this->middlewares);
        unset($this->serviceProviders);
        unset($this->loadedProviders);
        unset($this->deferredServices);
        unset($this->bindings);
        unset($this->instances);
        unset($this->reboundCallbacks);

        unset($this->resolved);
        unset($this->aliases);
    }
}