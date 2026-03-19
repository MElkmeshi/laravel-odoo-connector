<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('mrp.immediate.production.line')]
class MrpImmediateProductionLine extends OdooModel
{
    public function mrp_immediate_production(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.MrpImmediateProduction');
        return $this->belongsTo($relation, 'immediate_production_id', 'id');
    }

    public function mrp_production(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.MrpProduction');
        return $this->belongsTo($relation, 'production_id', 'id');
    }
}
