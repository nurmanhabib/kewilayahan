<?php

namespace Nurmanhabib\Kewilayahan;

use Nurmanhabib\Kewilayahan\Contracts\DataSourceContract;
use Nurmanhabib\Kewilayahan\Contracts\OutputContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class KewilayahanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConfig();
        $this->registerMigration();
        $this->registerRoute();
    }

    public function register()
    {
        $config = ConfigLoader::load();

        if ($this->app['config']->has('kewilayahan')) {
            $config->appends(
                $this->app['config']->get('kewilayahan')
            );
        }

        $this->app['config']->set([
            'kewilayahan' => $config->toArray()
        ]);

        $this->app->bind(DataSourceContract::class, function ($app) {
            $datasource = $app['config']->get('kewilayahan.default.datasource', 'eloquent');
            
            if ($datasource === 'eloquent') {
                $class  = $app['config']->get('kewilayahan.datasources.eloquent.class');
                $models = $app['config']->get('kewilayahan.datasources.eloquent.models');

                return new $class($models);
            } else {
                $class  = $app['config']->get('kewilayahan.datasources.'.$datasource.'.class');

                return new $class;
            }
        });

        $this->app->bind(OutputContract::class, function ($app) {
            $output = $app['config']->get('kewilayahan.default.output', 'json');            
            $class  = $app['config']->get('kewilayahan.outputs.' . $output);

            return new $class;
        });

        $this->app->bind('kewilayahan', function ($app) {
            $datasource = $app->make(DataSourceContract::class);
            $output     = $app->make(OutputContract::class);           

            return new Kewilayahan($datasource, $output);
        });
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'kewilayahan'
        );

        $this->publishes([
            __DIR__.'/../config/config.php' => $this->app->configPath('kewilayahan.php'),
        ], 'config');
    }

    protected function registerMigration()
    {
        $filename = date('Y_m_d_His', time()) . '_create_kewilayahan_tables.php';

        $this->publishes([
            __DIR__.'/../database/migrations/2016_03_13_030715_create_kewilayahan_tables.php' => $this->app->databasePath() . '/migrations/' . $filename,
        ], 'migration');
    }

    protected function registerRoute()
    {
        $api_enable = $this->app['config']->get('kewilayahan.api.enable', true);

        if ($api_enable) {
            $groups = [
                'namespace' => 'Nurmanhabib\Kewilayahan\Http\Controllers',
                'prefix'    => $this->app['config']->get('kewilayahan.api.path', 'api/v1/kewilayahan'),
            ];

            $router = $this->getRouter();
            
            if (! $this->app->routesAreCached()) {
                $router->group($groups, function () use ($router) {
                    require __DIR__.'/Http/routes.php';
                });
            }
        }
    }

    protected function getRouter()
    {
        return app('Illuminate\Routing\Router');
    }
}