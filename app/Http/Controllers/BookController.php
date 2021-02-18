<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BooksColection as BookResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function topBooks($count)
    {
        $book = Book::select()
            ->orderBy('views', 'DESC')
            ->limit($count)
            ->get();
        return new BookResource($book);
    }
}
