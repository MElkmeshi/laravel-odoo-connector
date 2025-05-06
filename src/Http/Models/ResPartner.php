<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class ResPartner extends OdooModel
{
    use SoftDeleteOdoo;

    protected $table = 'res.partner';

    public function user(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ResUser');
        return $this->belongsTo($relation, 'user_id', 'id')->withTrashed();
    }

    public function team(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.CrmTeam');
        return $this->belongsTo($relation, 'team_id', 'id')->withTrashed();
    }

    public function categories(): BelongsToMany
    {
        $relation = config('laravel-odoo-connector.ResPartnerCategory');
        return $this->belongsToMany($relation, 'not_needed', 'partner_ids', 'category_id')->withTrashed();
    }
}
