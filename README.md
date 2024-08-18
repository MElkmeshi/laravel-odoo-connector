# laravel-odoo-connector
Driver to connect Odoo using ORM of laravel

## Installation - Composer

You can install the package via composer:

```
composer require sefirosweb/laravel-odoo-connector
```

## Add in database.php the configuration for odoo
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

## Usage

Import the models of odoo in your controller

```php
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductProduct;

class YourController extends Controller
{
    public function index()
    {
        $products = ProductProduct::where('name', 'like', '%product%')->with('mrp_bom')->get();
        return view('products.index', compact('products'));
    }
}
```

You can use all methods of Eloquent ORM, like `find`, `where`, `whereHas`, `with`, `create`, `update`, `delete`, etc.

```php
$product = ProductProduct::find(1);
$product->name = 'New name';
$product->save();

$product = ProductProduct::create([
    'name' => 'Product 1',
    'description' => 'Description of product 1',
    'list_price' => 100,
    // ...
]);
```

## Customize your models
A lot of times you need to modify the models or create new ones, publish the config file and extends the models and,

```php
class YourCustomProductProduct extends Sefirosweb\LaravelOdooConnector\Http\Models\ProductProduct
{
    protected $table = 'product.product';

    public function your_custom_belongs(): BelongTo
    {
        return $this->belongsTo(YourCustomModel::class, 'your_field_id');
    }
}
```


### Publish config, to make override of Odoo Models

```bash
php artisan vendor:publish --provider="Sefirosweb\LaravelOdooConnector\LaravelOdooConnectorServiceProvider"  --tag=config --force
```

With that you can add more relations or edit them, configure your own models, in the file `config/laravel-odoo-connector.php`

```php

return [
    'ProductProduct' => App\Http\Models\YourCustomProductProduct::class,
    'ProductTemplate' => Sefirosweb\LaravelOdooConnector\Http\Models\ProductTemplate::class,
    'ResLang' => Sefirosweb\LaravelOdooConnector\Http\Models\ResLang::class,
    ///...
];

```

### SoftDelete
If you need to use soft delete "active" import the trait Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo

```php
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class ProductProduct extends OdooModel
{
    use SoftDeleteOdoo;
    // ...
}
```

## Multiple Odoo Connections
Add in database.php the configuration for odoo, only add connection in the model

```php
use Sefirosweb\LaravelOdooConnector\Http\Models\OdooModel;

class YourMainOdooModel extends OdooModel
{
    protected $connection = 'other_odoo_connection';

    public function getConnection()
    {
        return app('db')->connection('other_odoo_connection');
    }
}
```

## Custom get all records
If you need to get all records, you can use the method `get_all` in the model, this is execute in chunks of 500 records to avoid odoo timeout, is same has `all` method of Eloquent ORM

```php
$products = ProductProduct::get_all('id', 'name', 100);
```