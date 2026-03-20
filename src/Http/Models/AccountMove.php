<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name:'account.move')]
class AccountMove extends OdooModel
{
    public function account_move_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.AccountMoveLine');
        return $this->hasMany($relation, 'move_id', 'id');
    }
}
