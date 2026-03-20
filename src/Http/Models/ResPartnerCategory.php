<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

#[Table(name:'res.partner.category')]
class ResPartnerCategory extends OdooModel
{
    use SoftDeleteOdoo;

    public function partners(): BelongsToMany
    {
        $relation = config('laravel-odoo-connector.ResPartner');
        return $this->belongsToMany($relation, 'not_needed', 'category_id', 'partner_ids')->withTrashed();
    }
}
