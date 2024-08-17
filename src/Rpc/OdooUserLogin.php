<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Rpc;

use Exception;
use Illuminate\Support\Facades\Http;

class OdooUserLogin
{
    public $uid = null;
    public function __construct(
        public $url,
        public $database,
        public $username,
        public $password,
        public $defaultOptions = []
    ) {
        $this->login();
    }

    private function login()
    {
        $data = [
            "jsonrpc" => "2.0",
            "method" => "call",
            "params" => [
                "service" => "common",
                "method" => "login",
                "args" => [
                    $this->database,
                    $this->username,
                    $this->password
                ]
            ]
        ];

        $timeout = $this->defaultOptions['timeout'] ?? 20;

        $response = Http::timeout($timeout)->accept('application/json')->post($this->url . '/jsonrpc', $data)->json();

        if (!$response) {
            throw new Exception('Cant connect to to odoo server!');
        }

        if (isset($response['error'])) {
            throw new Exception($response['error']['data']['message']);
        }

        $this->uid = $response['result'];
        return $this->uid;
    }
}
