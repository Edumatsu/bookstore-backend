<?php

namespace App\Http\Requests\Adapters;
use Illuminate\Support\Arr;

class BookRequestAdapter
{
    public static function transform(array $data): array
    {
        return [
            "Titulo" => Arr::get($data, "title"),
            "Editora" => Arr::get($data, "publishingCompany"),
            "Edicao" => Arr::get($data, "edition"),
            "AnoPublicacao" => Arr::get($data, "yearPublication"),
            "Valor" => Arr::get($data, "value"),
            "Autores" => Arr::get($data, "authors"),
            "Assuntos" => Arr::get($data, "subjects"),
        ];
    }

    public static function revert(array $data): array
    {
        return [
            "title" => Arr::get($data, "Titulo"),
            "publishingCompany" => Arr::get($data, "Editora"),
            "edition" => Arr::get($data, "Edicao"),
            "yearPublication" => Arr::get($data, "AnoPublicacao"),
            "value" => Arr::get($data, "Valor"),
            "authors" => Arr::get($data, "Autores"),
            "subjects" => Arr::get($data, "Assuntos"),
        ];
    }
}