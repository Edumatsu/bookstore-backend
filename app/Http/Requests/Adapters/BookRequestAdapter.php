<?php

namespace App\Http\Requests\Adapters;

class BookRequestAdapter {
    public static function transform(array $data): array
    {
        return [
            "Titulo" => $data["title"],
            "Editora" => $data["publishingCompany"],
            "Edicao" => $data["edition"],
            "AnoPublicacao" => $data["yearPublication"],
            "Valor" => $data["value"],
            "Autores" => $data["authors"],
        ];
    }
}