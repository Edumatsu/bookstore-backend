<?php

namespace App\Exceptions;

class SubjectException extends BookStoreException
{
    public static function notFound(): self
    {
        return new self("Assunto não encontrado");
    }

    public static function unableToSave(): self
    {
        return new self("Não foi possível salvar o assunto no banco de dados");
    }
}
