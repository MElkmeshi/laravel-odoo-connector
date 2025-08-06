<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Sefirosweb\LaravelOdooConnector\Rpc\OdooJsonRpc;

class OdooEloquentBuilder extends Builder
{
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
        $offset = ($page - 1) * $perPage;

        $query = $this->getQuery();
        $grammar = $query->getGrammar();

        $domain = $grammar->convertWheresToOdooFilters($query, $query->wheres);

        $items = $this->offset($offset)
            ->limit($perPage)
            ->get($columns);

        $total = OdooJsonRpc::execute_kw(
            (new $this->model)->getTable(),
            'search_count',
            [$domain]
        );

        return new LengthAwarePaginator(
            $items,
            (int) $total,
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }
    public function forPage($page, $perPage = 15)
    {
        $offset = ($page - 1) * $perPage;
        return $this->offset($offset)->limit($perPage);
    }
    public function chunk($size, $callback)
    {
        $page = 1;

        do {
            $results = $this->forPage($page, $size)->get();
            $page++;
        } while ($results->isNotEmpty() && $callback($results, $page) !== false);
    }
}
