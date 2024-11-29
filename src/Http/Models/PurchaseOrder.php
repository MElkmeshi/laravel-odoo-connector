<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends OdooModel
{
    protected $table = 'purchase.order';

    public function purchase_order_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.PurchaseOrderLine');
        return $this->hasMany($relation, 'order_id', 'id');
    }
}
