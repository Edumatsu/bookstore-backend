<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    private $model;

    public function __construct()
    {
        $this->query();
    }

    protected function setInstanceModel($model): void
    {
        $this->model = $model;
    }

    protected function hasFilter(array $filters, string $name): bool
    {
        return array_key_exists($name, $filters) && $name && $filters[$name] !== null;
    }

    protected function filter(array $filters, string $name, callable $callback): ?callable
    {
        if (!$this->hasFilter($filters, $name)) {
            return null;
        }

        $callback($filters[$name]);
    }

    public function find(int $id, ?string $attribute="id", ?array $columns = array('*')): ?Model
    {
        return $this->query()
            ->select($columns)
            ->where($attribute, "=", $id)
            ->first();
    }

    public function findBy(string $attribute, string $value, ?array $columns = array('*')): ?Model
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function all(?array $columns = array('*')): Collection
    {
        return $this->query()->get($columns);
    }

    public function create(array $data): ?Model
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id, ?string $attribute="id"): ?Model
    {
        $this->model->where($attribute, '=', $id)->update($data);

        return $this->model->where($attribute, '=', $id)->first();
    }

    public function delete(int $id, ?string $attribute="id"): ?Model
    {
        $data = $this->model->where($attribute, '=', $id);
        $response = $data->first();
        $data->delete();

        return $response;
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }
}