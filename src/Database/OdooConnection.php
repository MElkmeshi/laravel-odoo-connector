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
            'res.partner',
            'search_read',
            [],
            [
                'fields' => ['id', 'name'],
                // 'domain' => $domain,
                'limit' => 5,
            ],
            $this->config['conection']
        );

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
