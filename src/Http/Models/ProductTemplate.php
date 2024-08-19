<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class ProductTemplate extends OdooModel
{
    use SoftDeleteOdoo;

    protected $table = 'product.template';

    public function product_products(): HasMany
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->hasMany($relation, 'product_tmpl_id', 'id');
    }

    public function mrp_bom(): HasMany
    {
        $relation = config('laravel-odoo-connector.MrpBom');
        return $this->hasMany($relation, 'product_tmpl_id', 'id');
    }

    public function stock_routes(): BelongsToMany
    {
        $relation = config('laravel-odoo-connector.StockRoute');
        return $this->belongsToMany($relation, 'not_needed', 'product_ids', 'route_ids');
    }
}
