<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title', 'description', 'author', 'publisher',
        'cover', 'price', 'weight', 'stock', 'status'
    ];
}
