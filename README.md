# laravel-odoo-connector
Driver to connect Odoo using ORM of laravel

# Add in database.php the configuration for odoo
```php
// database.php
    'connections' => [
        // ...

        'odoo' => [
            'driver' => 'odoo',
            'host' => env('ODOO_HOST', 'https://your-odoo-host.com'),
            'database' => env('ODOO_DB', 'db_name'),
            'username' => env('ODOO_USERNAME', 'user'),
            'password' => env('ODOO_PASSWORD', 'api_key'),
            'defaultOptions' => [
                'timeout' => 20,
                'context' => [
                    'lang' => 'es_ES'
                ],
            ],
        ],

    ],
```

## Publish config, to make override of Odoo Models

```bash
php artisan vendor:publish --provider="Sefirosweb\LaravelOdooConnector\LaravelOdooConnectorServiceProvider"  --tag=config --force
```

With that you can add more relations or edit them, configure your own models, in the file `config/laravel-odoo-connector.php`

```php

return [
    'ProductProduct' => Sefirosweb\LaravelOdooConnector\Http\Models\ProductProduct::class,
    'ProductTemplate' => Sefirosweb\LaravelOdooConnector\Http\Models\ProductTemplate::class,
    'ResLang' => Sefirosweb\LaravelOdooConnector\Http\Models\ResLang::class,
    ///...
];

```