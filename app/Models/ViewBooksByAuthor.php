<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewBooksByAuthor extends Model
{
    use HasFactory;
    
    public $table = "view_books_by_author";
}
