<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Database;

class OdooConnector
{
    protected $config;

    public function __construct()
    {
    }

    public function connect(array $config)
    {
        $pdo = null;
        $this->config = $config;

        $connection = new OdooConnection($pdo, $config['database'], '', $config);
        $connection->setQueryGrammar(new OdooGrammar($connection));
        return $connection;
    }
}
