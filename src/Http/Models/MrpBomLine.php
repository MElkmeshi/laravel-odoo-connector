<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(table: 'mrp.bom.line')]
class MrpBomLine extends OdooModel
{
    public function mrp_bom(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.MrpBom');
        return $this->belongsTo($relation, 'bom_id', 'id');
    }

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

    public function uom_uom(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.UomUom');
        return $this->belongsTo($relation, 'product_uom_id', 'id');
    }
}
