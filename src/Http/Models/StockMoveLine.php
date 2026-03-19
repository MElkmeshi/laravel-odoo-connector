<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(table: 'stock.move.line')]
class StockMoveLine extends OdooModel
{
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

    public function product_product(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->belongsTo($relation, 'product_id', 'id')->withTrashed();
    }
}
