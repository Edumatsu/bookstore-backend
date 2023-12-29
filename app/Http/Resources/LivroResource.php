<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LivroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'Codl' => (int) $this->Codl,
            'Titulo' => $this->Titulo,
            'Editora' => $this->Editora,
            'Edicao' => (int) $this->Edicao,
            'AnoPublicacao' => $this->AnoPublicacao,
        ];
    }
}
