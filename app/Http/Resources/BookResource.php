<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->Codl,
            'title' => $this->Titulo,
            'publishingCompany' => $this->Editora,
            'edition' => (int) $this->Edicao,
            'yearPublication' => $this->AnoPublicacao,
            'value' => (float) $this->Valor,
            'authors' => AuthorResource::collection($this->authors),
            'subjects' => SubjectResource::collection($this->subjects),
        ];
    }
}
