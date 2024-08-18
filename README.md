# laravel-odoo-connector

Driver to connect Odoo using ORM of laravel, it is based in JSON RPC. 

[Odoo Web Services Documentation JSON RPC](https://www.odoo.com/documentation/master/developer/howtos/web_services.html).

## Why use laravel-odoo-connector instead a postgresql connection?
It seems that it is easier to connect directly to the postgres database instead of using laravel-odoo-connector (based on json-rpc)

The advantage is that when you execute actions like "modify" or "create" objects, odoo has triggers that fire automated actions,

If you execute this in a raw postgress statement these events / actions will not be executed, so it is important to follow the odoo workflow, and odoo provides us with json-rpc to be able to perform these actions,

For example you could have a trigger in odoo that sends the invoice to the client when it is created,

Also laravel-odoo-connector provides the ability to execute model "actions",

For example once the SaleOrder is created it can be confirmed
```php
$sale_order = SaleOrder::find(1);
$sale_order->action('action_confirm');
```
It triggers the button "confirm" in the [odoo model](https://github.com/odoo/odoo/blob/a80f9a4be4c4da8980067d1ba9beca53b431f83b/addons/sale/models/sale_order.py#L918)

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

## Model Actions
You can execute actions of the model, for example, confirm a sale order

```php
$sale_order = SaleOrder::find(1);
$sale_order->action('action_confirm');
```

For custom actions you can provide more data;
    
```php
$args = [['id' => 1]];
SaleOrder::model_action('action_custom', $args);
```

## TODOS
 * Add the rest of models of Odoo (pos, pos_line...)