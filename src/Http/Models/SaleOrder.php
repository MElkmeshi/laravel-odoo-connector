<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleOrder extends OdooModel
{
    protected $table = 'sale.order';

    public function sale_order_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.SaleOrderLine');
        return $this->hasMany($relation, 'order_id', 'id');
    }
}
