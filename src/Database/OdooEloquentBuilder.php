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

    public function getCountForPagination($columns = ['*'])
    {
        $query = $this->getQuery();

        if (!empty($query->groups) || isset($query->aggregate) || $query->distinct) {
            return parent::getCountForPagination($columns);
        }

        $grammar = $query->getGrammar();

        if (!method_exists($grammar, 'convertWheresToOdooFilters')) {
            return parent::getCountForPagination($columns);
        }

        $domain = $grammar->convertWheresToOdooFilters($query, $query->wheres ?? []);

        $total = OdooJsonRpc::execute_kw(
            $this->getModel()->getTable(),
            'search_count',
            [$domain]
        );

        return (int) $total;
    }
}
