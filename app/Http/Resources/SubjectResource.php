<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class SubjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->codAs,
            'description' => $this->Descricao,
        ];
    }
}
