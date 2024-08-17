<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector;

use Illuminate\Support\ServiceProvider;
use Sefirosweb\LaravelOdooConnector\Commands\TestOdooConnection;
use Illuminate\Support\Facades\DB;
use Sefirosweb\LaravelOdooConnector\Database\OdooConnector;

class LaravelOdooConnectorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestOdooConnection::class,
            ]);
        }

        DB::extend('odoo', function ($config, $conection) {
            $config['conection'] = $conection;
            return (new OdooConnector)->connect($config);
        });
    }
}
