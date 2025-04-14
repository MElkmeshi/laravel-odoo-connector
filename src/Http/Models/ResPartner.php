<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sefirosweb\LaravelOdooConnector\Http\Traits\SoftDeleteOdoo;

class ResPartner extends OdooModel
{
    use SoftDeleteOdoo;

    protected $table = 'res.partner';

    public function user(): BelongsTo
    {
        return $this->belongsTo(ResUser::class, 'user_id', 'id')->withTrashed();
    }
}
