<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\Connection;
use Sefirosweb\LaravelOdooConnector\Rpc\OdooJson2;

class OdooConnection extends Connection
{
    public function select($query, $bindings = [], $useReadPdo = true)
    {
        return OdooJson2::call(
            $query['model'],
            $query['method'],
            $query['body'] ?? [],
            [],
            $this->config['conection']
        );
    }

    public function insert($query, $bindings = [])
    {
        return OdooJson2::call(
            $query['model'],
            $query['method'],
            $query['body'] ?? [],
            [],
            $this->config['conection']
        );
    }

    public function update($query, $bindings = [])
    {
        return OdooJson2::call(
            $query['model'],
            $query['method'],
            $query['body'] ?? [],
            [],
            $this->config['conection']
        );
    }

    public function delete($query, $bindings = [])
    {
        return OdooJson2::call(
            $query['model'],
            $query['method'],
            $query['body'] ?? [],
            [],
            $this->config['conection']
        );
    }

    protected function getDefaultPostProcessor()
    {
        return new OdooProcessor;
    }
}
