<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleOrderLine extends OdooModel
{
    protected $table = 'sale.order.line';

    public function sale_order(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.SaleOrder');
        return $this->belongsTo($relation, 'order_id', 'id');
    }

    public function product_product(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->belongsTo($relation, 'product_id', 'id');
    }

    public function stock_moves(): HasMany
    {
        $relation = config('laravel-odoo-connector.StockMove');
        return $this->hasMany($relation, 'sale_line_id', 'id');
    }

    public function purchase_order_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.PurchaseOrderLine');
        return $this->hasMany($relation, 'sale_line_id', 'id');
    }
}
