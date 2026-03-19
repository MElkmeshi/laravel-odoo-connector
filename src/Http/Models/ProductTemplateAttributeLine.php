<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

#[Table(table: 'product.template.attribute.line')]
class ProductTemplateAttributeLine extends OdooModel
{
    use SoftDeleteOdoo;
}
