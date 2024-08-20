<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MrpImmediateProductionLine extends OdooModel
{
    protected $table = 'mrp.immediate.production.line';

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
