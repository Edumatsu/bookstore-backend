<?php

namespace App\Exceptions;

class AuthorException extends BookStoreException
{
    public static function notFound(): self
    {
        return new self("Autor não encontrado");
    }

    public static function unableToSave(): self
    {
        return new self("Não foi possível salvar o autor no banco de dados");
    }
}
