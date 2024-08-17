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
            $query['filters'],
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
        throw new \Exception('Not implemented yet');
    }

    public function update($query, $bindings = [])
    {
        throw new \Exception('Not implemented yet');
    }

    public function delete($query, $bindings = [])
    {
        throw new \Exception('Not implemented yet');
    }
}
