<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

class StockMove extends OdooModel
{
    protected $table = 'stock.move';

    public function stock_picking()
    {
        $relation = config('laravel-odoo-connector.StockPicking');
        return $this->belongsTo($relation, 'picking_id', 'id');
    }
}
