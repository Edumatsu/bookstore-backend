<?php

namespace App\Exceptions;

class BookException extends BookStoreException
{
    public static function notFound(): self
    {
        return new self("Livro não encontrado");
    }

    public static function unableToSave(): self
    {
        return new self("Não foi possível salvar o livro no banco de dados");
    }
}