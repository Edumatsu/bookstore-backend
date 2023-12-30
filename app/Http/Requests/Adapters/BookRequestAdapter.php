<?php

namespace App\Http\Requests\Adapters;

class BookRequestAdapter
{
    public static function transform(array $data): array
    {
        return [
            "Titulo" => $data["title"],
            "Editora" => $data["publishingCompany"],
            "Edicao" => $data["edition"],
            "AnoPublicacao" => $data["yearPublication"],
            "Valor" => $data["value"],
            "Autores" => $data["authors"],
            "Assuntos" => $data["subjects"],
        ];
    }

    public static function revert(array $data): array
    {
        return [
            "title" => $data["Titulo"],
            "publishingCompany" => $data["Editora"],
            "edition" => $data["Edicao"],
            "yearPublication" => $data["AnoPublicacao"],
            "value" => $data["Valor"],
            "authors" => $data["Autores"],
            "subjects" => $data["Assuntos"],
        ];
    }
}