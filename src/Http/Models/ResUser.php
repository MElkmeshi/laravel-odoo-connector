<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class ResUser extends OdooModel
{
    use SoftDeleteOdoo;

    protected $table = 'res.users';

    public function partners(): HasMany
    {
        $relation = config('laravel-odoo-connector.ResPartner');
        return $this->hasMany($relation, 'user_id', 'id')->withTrashed();
    }
}
