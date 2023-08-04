<?php

namespace Locomotif\Admin;

use Illuminate\Support\ServiceProvider;
use Locomotif\Admin\Commands\SeederCommands;


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
        $this->app->make('Locomotif\Admin\Controller\UsersController');
        $this->app->make('Locomotif\Admin\Controller\AccountsController');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SeederCommands::class,
            ]);
        }

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        
        $this->loadViewsFrom(__DIR__.'/views',           'admin');
        $this->loadViewsFrom(__DIR__.'/views/users',     'users');
        $this->loadViewsFrom(__DIR__.'/views/accounts',  'accounts');
        $this->loadViewsFrom(__DIR__.'/views/designers', 'designers');
        $this->loadViewsFrom(__DIR__.'/views/clients',   'clients');

        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        //$this->call(RolesTableSeeder::class);
        
        $this->publishes([
            __DIR__.'/views/' => resource_path('views/locomotif/admin'),
        ]);
         $this->publishes([
            __DIR__.'/assets/' => base_path('public/backend/locomotif'),
        ]);

        //$this->loadViewsFrom(resource_path('views/locomotif/admin'), 'admin');
        
    }
}
