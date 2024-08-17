<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class ProductProduct extends OdooModel
{
    use SoftDeleteOdoo;

    protected $table = 'product.product';

    public function product_template(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductTemplate');
        return $this->belongsTo($relation, 'product_tmpl_id', 'id');
    }

    public function mrp_bom(): HasMany
    {
        $relation = config('laravel-odoo-connector.MrpBom');
        return $this->hasMany($relation, 'product_id', 'id');
    }
}
