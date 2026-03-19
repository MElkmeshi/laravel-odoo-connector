<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;

#[Table(table: 'product.attribute')]
class ProductAttribute extends OdooModel
{
}
