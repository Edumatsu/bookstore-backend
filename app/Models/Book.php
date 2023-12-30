<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $table = 'Livro';

    protected $primaryKey = 'Codl';

    public $timestamps = false;

    protected $fillable = [
        'Titulo',
        'Editora',
        'Edicao',
        'AnoPublicacao',
        'Valor',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'Livro_Autor', 'Livro_Codl', 'Autor_CodAu');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'Livro_Assunto', 'Livro_Codl', 'Assunto_codAs');
    }
}
