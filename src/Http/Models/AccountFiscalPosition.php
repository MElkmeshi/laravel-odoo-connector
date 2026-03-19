<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

#[Table(table: 'account.fiscal.position')]
class AccountFiscalPosition extends OdooModel
{
    use SoftDeleteOdoo;
}
