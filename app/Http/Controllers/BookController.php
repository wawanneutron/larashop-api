<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BookColection;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = new BookColection(Book::all()); //bisa all() / get ()
        return $books;
    }

    public function view($id)
    {
        $book = new BookColection(Book::findOrFail($id));
        return $book;
    }
}
