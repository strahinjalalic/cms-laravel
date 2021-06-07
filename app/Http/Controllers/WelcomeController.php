<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Post;
use App\Category;

class WelcomeController extends Controller
{
    public function index() {
        // $search = request()->query('search');
        // if($search) {
        //     $posts = Post::where('title', 'LIKE', "%{$search}%")->simplePaginate(2);
        // } else {
        //     $posts = Post::simplePaginate(2);
        // }

        return view('home')->with('tags', Tag::all())->with('posts', Post::searched()->simplePaginate(2))->with('categories', Category::all());
    }
}
