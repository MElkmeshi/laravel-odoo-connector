<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductProduct extends OdooModel
{
    protected $table = 'product.product';

    public function product_template(): BelongsTo
    {
        return $this->belongsTo(ProductTemplate::class, 'product_tmpl_id', 'id');
    }
}
