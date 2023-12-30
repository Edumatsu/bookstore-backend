<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
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
