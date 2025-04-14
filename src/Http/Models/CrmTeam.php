<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class CrmTeam extends OdooModel
{
    use SoftDeleteOdoo;

    protected $table = 'crm.team';

    public function partners(): HasMany
    {
        $relation = config('laravel-odoo-connector.ResPartner');
        return $this->hasMany($relation, 'team_id', 'id')->withTrashed();
    }

    public function team_leader(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ResUser');
        return $this->belongsTo($relation, 'user_id', 'id')->withTrashed();
    }

    public function team_members(): BelongsToMany
    {
        $relation = config('laravel-odoo-connector.ResUser');
        return $this->belongsToMany($relation, 'not_needed', 'crm_team_ids', 'member_ids');
    }

}
