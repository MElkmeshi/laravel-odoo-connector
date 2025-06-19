<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockMove extends OdooModel
{
    protected $table = 'stock.move';

    public function stock_picking(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.StockPicking');
        return $this->belongsTo($relation, 'picking_id', 'id');
    }

    public function stock_move_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.StockMoveLine');
        return $this->hasMany($relation, 'move_id', 'id');
    }

    public function sale_order_line(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.SaleOrderLine');
        return $this->belongsTo($relation, 'sale_line_id', 'id');
    }

    public function product_product(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->belongsTo($relation, 'product_id', 'id')->withTrashed();
    }
}
