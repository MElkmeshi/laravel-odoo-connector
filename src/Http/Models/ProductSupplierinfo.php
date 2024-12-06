<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSupplierinfo extends OdooModel
{
    protected $table = 'product.supplierinfo';

    public function product_product(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->belongsTo($relation, 'product_id', 'id')->withTrashed();
    }

    public function product_template(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductTemplate');
        return $this->belongsTo($relation, 'product_tmpl_id', 'id')->withTrashed();
    }
}
