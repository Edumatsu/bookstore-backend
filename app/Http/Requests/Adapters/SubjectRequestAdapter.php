<?php

namespace App\Http\Requests\Adapters;
use Illuminate\Support\Arr;

class SubjectRequestAdapter
{
    public static function transform(array $data): array
    {
        return [
            "Descricao" => Arr::get($data, "description"),
        ];
    }

    public static function revert(array $data): array
    {
        return [
            "description" => Arr::get($data, "Descricao"),
        ];
    }
}