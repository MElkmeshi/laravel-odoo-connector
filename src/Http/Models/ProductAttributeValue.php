<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;

#[Table(name:'product.attribute.value')]
class ProductAttributeValue extends OdooModel
{
}
