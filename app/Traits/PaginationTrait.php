<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait PaginationTrait
{
    public static function all($columns = ['*'])
    {
        if (filter_var(request('pagination', true), FILTER_VALIDATE_BOOLEAN)) {
            $query = static::query()->select($columns);
            if (filter_var(request('per_page'), FILTER_VALIDATE_INT)) {
                return $query->paginate(request('per_page'));
            }

            return $query->paginate();
        }

        return parent::all($columns);
    }

    public static function get($columns = ['*'])
    {
        if (filter_var(request('pagination', true), FILTER_VALIDATE_BOOLEAN)) {
            $query = static::query()->select($columns);
            if (filter_var(request('per_page'), FILTER_VALIDATE_INT)) {
                return $query->paginate(request('per_page'));
            }

            return $query->paginate();
        }

        return parent::get($columns);
    }

    public static function getPagination(Builder $builder, $columns = ['*'])
    {
        $builder->select($columns);

        if (filter_var(request('pagination', true), FILTER_VALIDATE_BOOLEAN)) {
            if (filter_var(request('per_page'), FILTER_VALIDATE_INT)) {
                return $builder->paginate(request('per_page'));
            }

            return $builder->paginate();
        }

        return $builder->get($columns);
    }
}
