<?php

namespace App\Http\Requests\Adapters;

class AuthorRequestAdapter
{
    public static function transform(array $data): array
    {
        return [
            "Nome" => $data["name"],
        ];
    }

    public static function revert(array $data): array
    {
        return [
            "name" => $data["Nome"],
        ];
    }
}