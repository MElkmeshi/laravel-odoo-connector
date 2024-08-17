<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OdooModel extends Model
{
    protected $connection = 'odoo';
    public $timestamps = false;

    public function getConnection()
    {
        return app('db')->connection('odoo');
    }
}
