<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait SoftDeleteOdoo
{
    use SoftDeletes;

    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SoftDeletingScope);
    }

    public function getDeletedAtColumn()
    {
        return defined(static::class . '::DELETED_AT') ? static::DELETED_AT : 'active';
    }

    public function initializeSoftDeletes()
    {
        if (! isset($this->casts[$this->getDeletedAtColumn()])) {
            $this->casts[$this->getDeletedAtColumn()] = 'boolean';
        }
    }

    protected function runSoftDelete()
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $time = false;

        $columns = [$this->getDeletedAtColumn() => $time];

        $this->{$this->getDeletedAtColumn()} = $time;

        $query->update($columns);

        $this->syncOriginalAttributes(array_keys($columns));

        $this->fireModelEvent('trashed', false);
    }
}
