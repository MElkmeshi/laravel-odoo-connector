<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class MrpBom extends OdooModel
{
    use SoftDeleteOdoo;

    protected $table = 'mrp.bom';

    public function product_product(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductProduct');
        return $this->belongsTo($relation, 'product_id', 'id');
    }

    public function product_template(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ProductTemplate');
        return $this->belongsTo($relation, 'product_tmpl_id', 'id');
    }

    public function mrp_bom_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.MrpBomLine');
        return $this->hasMany($relation, 'bom_id', 'id');
    }
}
