<?php

namespace App\Http\Requests\Adapters;

class SubjectRequestAdapter
{
    public static function transform(array $data): array
    {
        return [
            "Descricao" => $data["description"],
        ];
    }

    public static function revert(array $data): array
    {
        return [
            "description" => $data["Descricao"],
        ];
    }
}