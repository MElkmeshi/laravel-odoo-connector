<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Rpc;

use Exception;
use Illuminate\Support\Facades\Http;

class OdooJson2
{
    public static function call(string $model, string $method, array $body = [], array $headers = [], string $connection = 'odoo')
    {
        $cfg = config('database.connections.' . $connection);
        if (!$cfg) {
            throw new Exception("Odoo connection [$connection] not configured.");
        }

        $baseUrl = rtrim((string)($cfg['host'] ?? ''), '/');
        $apiKey  = (string)($cfg['api_key'] ?? '');
        $database = $cfg['database'] ?? null;

        if ($baseUrl === '' || $apiKey === '') {
            throw new Exception('Odoo host or api_key missing in connection config.');
        }

        $context = $cfg['defaultOptions']['context'] ?? null;
        if ($context) {
            $body['context'] = array_merge($body['context'] ?? [], $context);
        }

        $timeout = $cfg['defaultOptions']['timeout'] ?? 20;

        $reqHeaders = array_merge([
            'Authorization' => 'bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ], $headers);

        if ($database) {
            $reqHeaders['X-Odoo-Database'] = $database;
        }

        $url = "{$baseUrl}/json/2/{$model}/{$method}";

        $resp = Http::timeout($timeout)
            ->withHeaders($reqHeaders)
            ->post($url, $body);

        if (!$resp->ok()) {
            $payload = $resp->body();
            throw new Exception("Odoo JSON-2 error {$resp->status()}: {$payload}");
        }

        return $resp->json();
    }
}
