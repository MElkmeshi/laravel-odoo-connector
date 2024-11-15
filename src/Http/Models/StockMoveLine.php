<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMoveLine extends OdooModel
{
    protected $table = 'stock.move.line';

    public function stock_move(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.StockMove');
        return $this->belongsTo($relation, 'move_id', 'id');
    }

    public function stock_picking(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.StockPicking');
        return $this->belongsTo($relation, 'picking_id', 'id');
    }

    public function product(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->belongsTo($relation, 'product_id', 'id');
    }
}
