<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductTemplate extends OdooModel
{
    protected $table = 'product.template';

    public function product_products(): HasMany
    {
        return $this->hasMany(ProductProduct::class, 'product_tmpl_id', 'id');
    }
}
