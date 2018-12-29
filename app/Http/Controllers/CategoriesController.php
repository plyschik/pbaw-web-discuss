<?php

namespace App\Http\Controllers;

use App\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with(['users', 'forums' => function ($query) {
            $query->withCount(['topics', 'replies' => function ($query) {
                $query->where('is_topic', 0);
            }])->with(['replies' => function ($query) {
                $query->with(['topic', 'user'])->latest();
            }]);
        }])->get();

        return view('categories.index', compact('categories'));
    }
}