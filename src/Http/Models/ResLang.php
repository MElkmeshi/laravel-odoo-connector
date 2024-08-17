<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

class ResLang extends OdooModel
{
    protected $fillable = ['name'];
    protected $table = 'res.lang';
}
