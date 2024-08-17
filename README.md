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
´´´