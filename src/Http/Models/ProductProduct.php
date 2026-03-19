<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

#[Table(table: 'product.product')]
class ProductProduct extends OdooModel
{
    use SoftDeleteOdoo;

    public function product_template(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductTemplate');
        return $this->belongsTo($relation, 'product_tmpl_id', 'id')->withTrashed();
    }

    public function mrp_bom(): HasMany
    {
        $relation = config('laravel-odoo-connector.MrpBom');
        return $this->hasMany($relation, 'product_id', 'id');
    }

    public function product_supplierinfos(): HasMany
    {
        $relation = config('laravel-odoo-connector.ProductSupplierinfo');
        return $this->hasMany($relation, 'product_id', 'id');
    }
}
