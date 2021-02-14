<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\NotIn;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::paginate(10);
        $books = Book::paginate(10);
        $categories = Category::all();

        return view('home', [
            'users' => $users,
            'books' => $books,
            'categories' => $categories
        ]);
    }



    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $avatar = $request->file('avatar');

        if ($avatar) {
            $path = $avatar->store('users', 'public');
            $user->avatar = $path;
        }
        $user->save();

        return redirect()->route('home')->with('success', 'Update  is successfully');
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $cover = $request->file('cover');

        // book
        if ($cover) {
            $path = $cover->store('books', 'public');
            $book->cover = $path;
        }

        $book->save();
        return redirect()->route('home')->with('success', 'Update  is successfully');
    }

    public function updateCategory(Request $request, $id)
    {
        $bookCategory = Category::find($id);

        $image = $request->file('image');

        if ($image) {
            $path = $image->store('categories', 'public');
            $bookCategory->image = $path;
        }
        $bookCategory->save();
        return redirect()->route('home')->with('success', 'Update  is successfully');
    }



    public function deleteUser($id)
    {
        $delUser = User::findOrFail($id);

        $delUser->delete();
        return redirect()->route('home')->with('delete', 'Delete  is successfully');
    }

    public function deleteBook($id)
    {
        $delBook = Book::findOrFail($id);

        $delBook->delete();
        return redirect()->route('home')->with('delete', 'Delete  is successfully');
    }
}
