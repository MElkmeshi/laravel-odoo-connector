<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class StockRoute extends OdooModel
{
    protected $table = 'stock.route';
    use SoftDeleteOdoo;

    public function product_templates(): BelongsToMany
    {
        $relation = config('laravel-odoo-connector.ProductTemplate');
        return $this->belongsToMany($relation, 'not_needed', 'route_ids', 'product_ids')->withTrashed();
    }
}
