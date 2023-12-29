<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Autor extends Model
{
    protected $table = "Autor";

    protected $primaryKey = 'CodAu';

    public $timestamps = false;

    protected $fillable = [
        'Nome',
    ];

    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Livro::class, 'Livro_Autor', 'Autor_CodAu', 'Livro_Codl');
    }
}
