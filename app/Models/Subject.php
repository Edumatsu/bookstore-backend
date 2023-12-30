<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $table = "Assunto";

    protected $primaryKey = 'codAs';

    public $timestamps = false;

    protected $fillable = [
        'Descricao',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'Livro_Assunto', 'Assunto_codAs', 'Livro_Codl');
    }
}
