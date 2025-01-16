<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountMove extends OdooModel
{
    protected $table = 'account.move';

    public function account_move_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.AccountMoveLine');
        return $this->hasMany($relation, 'move_id', 'id');
    }
}
