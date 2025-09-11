<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Sefirosweb\LaravelOdooConnector\Rpc\OdooJson2;

class OdooEloquentBuilder extends Builder
{
public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
{
    $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
    $offset = ($page - 1) * $perPage;

    $query   = $this->getQuery();
    $grammar = $query->getGrammar();

    $domain = $grammar->convertWheresToOdooFilters($query, $query->wheres);

    $items = $this->offset($offset)
        ->limit($perPage)
        ->get($columns);

    $total = OdooJson2::call(
        (new $this->model)->getTable(),
        'search_count',
        ['domain' => $domain]
    );

    return new LengthAwarePaginator(
        $items,
        (int) $total,
        $perPage,
        $page,
        ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => $pageName]
    );
}

}
