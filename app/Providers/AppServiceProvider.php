<?php

namespace Sig\Providers;

use Illuminate\Support\ServiceProvider;
use Sig\Evaluacion;
use Sig\RequisitosMatriz;
use Sig\MigracionMatriz;
use Sig\Historicom;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->singleton('evaluacion', function($foo)
        {
            $query = Evaluacion::lists('Fecha','id');
            return   $query;
        });

        $this->app->singleton('Migraciones', function($foo)
        {
            $query = MigracionMatriz::All();
            return   $query;
        });

        $this->app->singleton('Historicos', function($foo)
        {
            $query = Historicos::All('','');
            return   $query;
        });                
    }
}
