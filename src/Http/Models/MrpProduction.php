<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MrpProduction extends OdooModel
{
    protected $table = 'mrp.production';

    public function product_product(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->belongsTo($relation, 'product_id', 'id');
    }

    public function mrp_immediate_production_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.MrpImmediateProductionLine');
        return $this->hasMany($relation, 'production_id', 'id');
    }
}
