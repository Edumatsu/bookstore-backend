<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class BooksByAuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->CodAu,
            'author' => $this->Autor,
            'book' => $this->Livro,
            'publishingCompany' => $this->Editora,
            'edition' => (int) $this->Edicao,
            'yearPublication' => $this->AnoPublicacao,
            'value' => (float) $this->Valor,
            'subjects' => $this->Assuntos
        ];
    }
}
