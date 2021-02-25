<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'author', 'publisher',
        'cover', 'price', 'weight', 'views', 'stock', 'status'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
