<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

#[Table(name:'res.users')]
class ResUser extends OdooModel
{
    use SoftDeleteOdoo;

    public function partners(): HasMany
    {
        $relation = config('laravel-odoo-connector.ResPartner');
        return $this->hasMany($relation, 'user_id', 'id')->withTrashed();
    }
}
