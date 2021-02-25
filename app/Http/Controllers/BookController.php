<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\Book as ResourcesBook;
use App\Http\Resources\BookDetail;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function topBooks($count)
    {
        $book = Book::select()
            ->orderBy('views', 'DESC') //mengurutkan berdasarkan view terbanyak
            ->limit($count)
            ->get();
        return new ResourcesBook($book);
    }

    public function allBooks()
    {
        $books = Book::paginate(6);
        return new ResourcesBook($books);
    }

    //detail book
    public function slug($slug)
    {
        $book = Book::where('slug', $slug)->first();
        $book->views = $book->views + 1;
        $book->save();
        return new BookDetail($book);
    }
}
