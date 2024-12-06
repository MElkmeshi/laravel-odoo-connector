<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderLine extends OdooModel
{
    protected $table = 'purchase.order.line';

    public function purchase_order(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.PurchaseOrder');
        return $this->belongsTo($relation, 'order_id', 'id');
    }

    public function product_product(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->belongsTo($relation, 'product_id', 'id')->withTrashed();
    }

    public function sale_order(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.SaleOrder');
        return $this->belongsTo($relation, 'sale_order_id', 'id');
    }

    public function sale_order_line(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.SaleOrderLine');
        return $this->belongsTo($relation, 'sale_line_id', 'id');
    }
}
