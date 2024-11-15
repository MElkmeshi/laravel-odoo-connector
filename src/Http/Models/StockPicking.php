<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockPicking extends OdooModel
{
    protected $table = 'stock.picking';

    public function sale_order(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.SaleOrder');
        return $this->belongsTo($relation, 'sale_id', 'id');
    }

    public function stock_move_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.StockMoveLine');
        return $this->hasMany($relation, 'picking_id', 'id');
    }
}
