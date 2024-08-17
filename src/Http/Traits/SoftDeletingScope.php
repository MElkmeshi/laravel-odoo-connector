<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope as EloquentSoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class SoftDeletingScope extends EloquentSoftDeletingScope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedDeletedAtColumn(), true);
    }

    protected function addWithoutTrashed(Builder $builder)
    {
        $builder->macro('withoutTrashed', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where(
                $model->getQualifiedDeletedAtColumn(),
                false
            );

            return $builder;
        });
    }
    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where(
                $model->getQualifiedDeletedAtColumn(),
                false
            );

            return $builder;
        });
    }

    protected function addWithTrashed(Builder $builder)
    {
        $builder->macro('withTrashed', function (Builder $builder, $withTrashed = true) {
            if (! $withTrashed) {
                return $builder->withoutTrashed();
            }

            $model = $builder->getModel();
            return $builder->withoutGlobalScope($this)
                ->where(function ($q) use ($model) {
                    $q->where($model->getQualifiedDeletedAtColumn(), false);
                    $q->orWhere($model->getQualifiedDeletedAtColumn(), true);
                });
        });
    }
}
