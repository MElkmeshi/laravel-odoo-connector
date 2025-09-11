<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar as BaseGrammar;

class OdooGrammar extends BaseGrammar
{
    protected $operators = [
        '=',
        '!=',
        '>',
        '>=',
        '<',
        '<=',
        'like',
        'not like',
        'ilike',
        'not ilike',
        'child_of',
        'parent_of',
    ];

    public function __construct(Connection $connection)
    {
        if (version_compare(app()->version(), '12.0', '>=')) {
            parent::__construct($connection);
        }
    }

    public function compileSelect(Builder $query)
    {
        $columns = $query->columns ?? [];
        if ($query->columns === ['*']) {
            $columns = [];
        }

        $domain = $this->convertWheresToOdooFilters($query, $query->wheres);

        return [
            'model'  => $query->from,
            'method' => 'search_read',            // JSON-2 method
            'body'   => array_filter([
                'domain' => $domain,
                'fields' => $columns ?: null,
                'limit'  => $query->limit,
                'offset' => $query->offset,
                // 'order' => 'name asc', // add if/when needed
            ], fn($v) => $v !== null),
        ];
    }

    public function compileInsert(Builder $query, array $values)
    {
        return [
            'model'  => $query->from,
            'method' => 'create',
            'body'   => ['values' => $values],
        ];
    }

    public function compileUpdate(Builder $query, array $values)
    {
        $ids = [];
        foreach ($query->wheres as $where) {
            if ($where['type'] === 'Basic' && $where['operator'] === '=' && $where['column'] === 'id') {
                $ids[] = $where['value'];
            }
        }

        return [
            'model'  => $query->from,
            'method' => 'write',
            'body'   => [
                'ids'    => $ids,
                'values' => $values,
            ],
        ];
    }

    public function compileDelete(Builder $query)
    {
        $ids = [];
        foreach ($query->wheres as $where) {
            if ($where['type'] === 'Basic' && $where['operator'] === '=' && $where['column'] === 'id') {
                $ids[] = $where['value'];
            }
        }

        return [
            'model'  => $query->from,
            'method' => 'unlink',
            'body'   => ['ids' => $ids],
        ];
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
            'ilike' => 'ilike',
            'not ilike' => 'not ilike',
            'child_of' => 'child_of',
            'parent_of' => 'parent_of',
        ];

        return $operators[$operator] ?? $operator;
    }
}
