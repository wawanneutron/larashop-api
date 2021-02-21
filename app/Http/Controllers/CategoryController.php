<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoriesColections;
use App\Http\Resources\Category as Collection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function random($count)
    {
        $categories = Category::select()
            ->inRandomOrder()
            ->limit($count)
            ->get();
        return new CategoriesColections($categories);
    }

    public function allCategory()
    {
        $categories = Category::paginate(6);
        return new Collection($categories);
    }
}
