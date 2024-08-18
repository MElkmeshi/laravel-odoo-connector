<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Sefirosweb\LaravelOdooConnector\Rpc\OdooJsonRpc;

class OdooModel extends Model
{
    protected $connection = 'odoo';
    public $timestamps = false;

    public function getConnection()
    {
        return app('db')->connection('odoo');
    }

    /**
     * Get all of the models from the database.
     *
     * @param  array|string  $columns
     * @param  int  $chunks
     * @return \Illuminate\Database\Eloquent\Collection<int, static>
     */
    public static function get_all($columns = ['*'], $chunks = 500)
    {
        $response = new Collection();
        $offset = 0;
        while (true) {
            $data = static::query()
                ->offset($offset)
                ->limit($chunks)
                ->get(
                    is_array($columns) ? $columns : func_get_args()
                );

            if ($data->isEmpty()) {
                break;
            }

            $offset += $chunks;
            $response = $response->merge($data);
        }

        return $response;
    }

    public function action(string $action)
    {
        if (!$this->id) {
            throw new \Exception('The model must have an id to perform this action');
        }

        OdooJsonRpc::execute_kw(
            $this->getTable(),
            $action,
            [
                [$this->id]
            ]
        );
    }

    public static function model_action(string $action, array $args)
    {
        $instance = new static();
        return OdooJsonRpc::execute_kw(
            $instance->getTable(),
            $action,
            $args
        );
    }
}
