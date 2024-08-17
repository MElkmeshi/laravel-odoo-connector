<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\Query\Processors\Processor;
use Illuminate\Database\Query\Builder;

class OdooProcessor extends Processor
{
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $id = $query->getConnection()->insert($sql, $values);
        return is_numeric($id) ? (int) $id : $id;
    }
}
