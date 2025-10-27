<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;
use Sefirosweb\LaravelOdooConnector\Rpc\OdooJsonRpc;

class OdooQueryBuilder extends BaseBuilder
{
    public function __construct(ConnectionInterface $connection, Grammar $grammar, Processor $processor)
    {
        parent::__construct($connection, $grammar, $processor);
    }

    protected function runPaginationCountQuery($columns = ['*'])
    {
        if ($this->groups || isset($this->aggregate) || $this->distinct) {
            return parent::runPaginationCountQuery($columns);
        }

        $grammar = $this->grammar;

        if (!method_exists($grammar, 'convertWheresToOdooFilters')) {
            return parent::runPaginationCountQuery($columns);
        }

        $domain = $grammar->convertWheresToOdooFilters($this, $this->wheres ?? []);

        $connectionName = $this->connection->getConfig('conection') ?? $this->connection->getName() ?? 'odoo';

        $count = OdooJsonRpc::execute_kw(
            $this->from,
            'search_count',
            [$domain],
            [],
            $connectionName
        );

        return [['aggregate' => (int) $count]];
    }
}
