<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(table: 'purchase.order')]
class PurchaseOrder extends OdooModel
{
    public function purchase_order_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.PurchaseOrderLine');
        return $this->hasMany($relation, 'order_id', 'id');
    }
}
