<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AccountMoveLine extends OdooModel
{
    protected $table = 'account.move.line';

    public function account_move(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.AccountMove');
        return $this->belongsTo($relation, 'move_id', 'id');
    }

    public function sale_order_lines(): BelongsToMany
    {
        $relation = config('laravel-odoo-connector.SaleOrderLine');
        return $this->belongsToMany($relation, 'not_needed', 'invoice_lines', 'sale_line_ids');
    }
}
