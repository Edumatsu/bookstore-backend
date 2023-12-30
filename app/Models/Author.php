<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $table = 'Autor';

    protected $primaryKey = 'CodAu';

    public $timestamps = false;

    protected $fillable = [
        'Nome',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'Livro_Autor', 'Autor_CodAu', 'Livro_Codl');
    }
}
