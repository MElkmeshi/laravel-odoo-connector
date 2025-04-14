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
        return $this->hasMany(ResPartner::class, 'user_id', 'id')->withTrashed();
    }
}
