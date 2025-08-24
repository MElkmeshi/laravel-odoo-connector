<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar as BaseGrammar;

class OdooGrammar extends BaseGrammar
{
    public function __construct(Connection $connection)
    {
        if (version_compare(app()->version(), '12.0', '>=')) {
            parent::__construct($connection);
        }
    }

    public function compileSelect(Builder $query)
    {
        // $oldSql = parent::compileSelect($query);
        $columns = $query->columns;

        if (empty($columns)) {
            $columns = [];
        }

        if ($query->columns === ['*']) {
            $columns = [];
        }

        $params = $this->convertWheresToOdooFilters($query, $query->wheres);

        $jsonRpc = [
            'model' => $query->from,
            'operation' => 'search_read',
            'params' => [$params],
            'object' => [
                'fields' => $columns,
                'limit' => $query->limit,
                'offset' => $query->offset,
            ],
        ];

        return $jsonRpc;
    }

    public function compileInsert(Builder $query, array $values)
    {
        $jsonRpc = [
            'model' => $query->from,
            'operation' => 'create',
            'params' => [$values],
            'object' => [],
        ];

        return $jsonRpc;
    }

    public function compileUpdate(Builder $query, array $values)
    {
        $ids = [];

        foreach ($query->wheres as $where) {
            if ($where['type'] === 'Basic' && $where['operator'] === '=' && $where['column'] === 'id') {
                $ids[] = $where['value'];
            }
        }

        $jsonRpc = [
            'model' => $query->from,
            'operation' => 'write',
            'params' => [$ids, $values],
            'object' => [],
        ];

        return $jsonRpc;
    }

    public function compileDelete(Builder $query)
    {
        $ids = [];

        foreach ($query->wheres as $where) {
            if ($where['type'] === 'Basic' && $where['operator'] === '=' && $where['column'] === 'id') {
                $ids[] = $where['value'];
            }
        }

        $jsonRpc = [
            'model' => $query->from,
            'operation' => 'unlink',
            'params' => [$ids],
            'object' => [],
        ];

        return $jsonRpc;
    }

    /**
     * Convert Laravel $wheres to Odoo filters.
     *
     * @param  array  $wheres
     * @return array
     */
    public function convertWheresToOdooFilters(Builder $query, array $wheres)
    {
        $filters = [];

        foreach ($wheres as $where) {
            switch ($where['type']) {
                case 'Basic':
                    $column = str_replace($query->from . '.', '', $where['column']);
                    $filter = [$column, $this->convertOperator($where['operator']), $where['value']];
                    break;
                case 'Null':
                    $column = str_replace($query->from . '.', '', $where['column']);
                    $filter = [$column, '=', null];
                    break;
                case 'NotNull':
                    $column = str_replace($query->from . '.', '', $where['column']);
                    $filter = [$column, '!=', null];
                    break;
                case 'In':
                    $column = str_replace($query->from . '.', '', $where['column']);
                    $filter = [$column, 'in', $where['values']];
                    break;
                case 'InRaw':
                    $column = str_replace($query->from . '.', '', $where['column']);
                    $filter = [$column, 'in', $where['values']];
                    break;
                case 'NotIn':
                    $column = str_replace($query->from . '.', '', $where['column']);
                    $filter = [$column, 'not in', $where['values']];
                    break;
                case 'Nested':
                    $nestedFilters = $this->convertWheresToOdooFilters($query, $where['query']->wheres);
                    if ($where['boolean'] === 'or') {
                        $filters = array_merge(
                            array_slice($filters, 0, -1),
                            ['|'],
                            array_slice($filters, -1, 1),
                            $nestedFilters
                        );
                    } else {
                        $filters = array_merge($filters, $nestedFilters);
                    }
                    continue 2; // Skip the default case
                default:
                    throw new \Exception("Unsupported where type: " . $where['type']);
            }

            if ($where['boolean'] === 'or') {
                $filters = array_merge(
                    array_slice($filters, 0, -1),
                    ['|'],
                    array_slice($filters, -1, 1),
                    [$filter]
                );
            } else {
                $filters[] = $filter;
            }
        }

        return $filters;
    }

    /**
     * Convert Laravel operator to Odoo operator.
     *
     * @param  string  $operator
     * @return string
     */
    protected function convertOperator(string $operator)
    {
        $operators = [
            '=' => '=',
            '<' => '<',
            '>' => '>',
            '<=' => '<=',
            '>=' => '>=',
            '<>' => '!=',
            '!=' => '!=',
            'like' => 'ilike',
            'not like' => 'not ilike',
        ];

        return $operators[$operator] ?? $operator;
    }
}
