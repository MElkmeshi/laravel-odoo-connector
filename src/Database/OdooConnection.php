<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

use Illuminate\Database\Connection;
use Sefirosweb\LaravelOdooConnector\Rpc\OdooJsonRpc;

class OdooConnection extends Connection
{
    public function select($query, $bindings = [], $useReadPdo = true)
    {
        $data = OdooJsonRpc::execute_kw(
            $query['model'],
            $query['operation'],
            $query['params'],
            $query['object'],
            $this->config['conection']
        );

        $data = array_map(function ($row) {
            foreach ($row as $key => $value) {
                if (is_array($value)) {
                    if (count($value) > 0) {
                        $row[$key] = $value[0];
                    } else {
                        $row[$key] = null;
                    }
                }
            }

            return $row;
        }, $data);

        return $data;
    }

    public function insert($query, $bindings = [])
    {
        $data = OdooJsonRpc::execute_kw(
            $query['model'],
            $query['operation'],
            $query['params'],
            $query['object'],
            $this->config['conection']
        );

        return $data;
    }

    public function update($query, $bindings = [])
    {
        $data = OdooJsonRpc::execute_kw(
            $query['model'],
            $query['operation'],
            $query['params'],
            $query['object'],
            $this->config['conection']
        );

        return $data;
    }

    public function delete($query, $bindings = [])
    {
        $data = OdooJsonRpc::execute_kw(
            $query['model'],
            $query['operation'],
            $query['params'],
            $query['object'],
            $this->config['conection']
        );

        return $data;
    }

    protected function getDefaultPostProcessor()
    {
        return new OdooProcessor;
    }
}
