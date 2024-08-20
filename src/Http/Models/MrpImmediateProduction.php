<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class MrpImmediateProduction extends OdooModel
{
    protected $table = 'mrp.immediate.production';

    public function mrp_immediate_production_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.MrpImmediateProductionLine');
        return $this->hasMany($relation, 'immediate_production_id', 'id');
    }
}
