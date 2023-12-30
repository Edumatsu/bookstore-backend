<?php

namespace App\Http\Requests\Adapters;
use Illuminate\Support\Arr;

class AuthorRequestAdapter
{
    public static function transform(array $data): array
    {
        return [
            'Nome' => Arr::get($data, 'name'),
        ];
    }

    public static function revert(array $data): array
    {
        return [
            'name' => Arr::get($data, 'Nome'),
        ];
    }
}