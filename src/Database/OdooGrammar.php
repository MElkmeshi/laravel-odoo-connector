<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar as BaseGrammar;

class OdooGrammar extends BaseGrammar
{
    public function compileSelect(Builder $query)
    {
        $sql = parent::compileSelect($query);
        $columns = $query->columns;

        if (empty($columns)) {
            $columns = [];
        }

        if ($query->columns === ['*']) {
            $columns = [];
        }

        $filters = $this->convertWheresToOdooFilters($query, $query->wheres);

        $jsonRpc = [
            'model' => $query->from,
            'operation' => 'search_read',
            'filters' => [$filters],
            'object' => [
                'fields' => $columns,
                'limit' => $query->limit,
            ],
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
        $orFilters = [];

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
                        $orFilters[] = ['|', ...$nestedFilters];
                    } else {
                        $filters = array_merge($filters, $nestedFilters);
                    }
                    continue 2; // Skip the default case
                default:
                    throw new \Exception("Unsupported where type: " . $where['type']);
            }

            if ($where['boolean'] === 'or') {
                array_unshift($filters, '|');
                $filters[] = $filter;
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
