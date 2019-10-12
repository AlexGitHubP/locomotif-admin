<?php

namespace Locomotif\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app['router']->aliasMiddleware('authgate', 'Locomotif\Admin\Middleware\Authgate');
        $this->app['router']->aliasMiddleware('dashboardgate', 'Locomotif\Admin\Middleware\RedirectIfAuth');
        $this->app->make('Locomotif\Admin\Controller\AdminController');
        $this->app->make('Locomotif\Admin\Controller\LoginController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        //$this->loadMigrationsFrom(__DIR__.'/Database/Migrations/');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views/', 'admin');
        
    }
}
