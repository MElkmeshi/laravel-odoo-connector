<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name:'product.supplierinfo')]
class ProductSupplierinfo extends OdooModel
{
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

    public function partner(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ResPartner');
        return $this->belongsTo($relation, 'partner_id', 'id')->withTrashed();
    }
}
