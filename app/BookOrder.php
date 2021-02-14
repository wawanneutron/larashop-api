<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    protected $table = 'book_order';
    protected $fillable = [
        'order_id', 'book_id', 'quantity'
    ];
}
