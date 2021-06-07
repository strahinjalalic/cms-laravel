<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Tag;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verifyCategory')->only(['create', 'store']);
    }

    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
        //return view('posts.index')->withPosts(Post::all()); => drugi nacin, dinamicki nastrojen
    }


    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }


    public function store(PostRequest $request)
    {
        $image = $request->image->store('posts'); //postaviti FILESYSTEM_DRIVER = public u .env fajlu => da bi bilo vidljivo, prebacuje se u public folder komandom php artisan storage:link

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => now(),
            'image' => $image,
            'category_id' => $request->category,
            'user_id' => auth()->user()->id
        ]);

        if($request->tags) {
            $post->tags()->attach($request->tags); //na poslednje kreiran post attachuje se niz sa tagovima
        }

        session()->flash('success', 'Post created successfully');

        return redirect()->route('posts.index');

    }


    public function show($id)
    {

    }


    public function edit(Post $post)
    {
        return view('posts.create')->withPost($post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'published_at', 'content']);

        if($request->hasFile('image')) {
            $image = $request->image->store('posts');
            $post->deleteImage();
            $data['image'] = $image;
        }

        if($request->tags) {
            $post->tags()->sync($request->tags); //metod koristan za many-to-many relacije => sinhronizuje nove vrednosti koje su prethodno attach-ovane
        }

        $post->update($data);
        session()->flash('success', 'Post updated successfully');
        return redirect()->route('posts.index');
    }


    public function destroy($id) //kada se izvrsava vise metoda, ne moze se koristiti route binding(Post $post) jer ga nece naci u bazi podataka
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        if($post->trashed()){
            $post->deleteImage();
            $post->forceDelete();
        } else {
            $post->delete();
        }

        session()->flash('success', 'Post deleted successfully');
        return redirect()->route('posts.index');
    }

    public function trashed() {
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->withPosts($trashed);
    }

    public function restore(Request $request, $id) {
        $restored = Post::onlyTrashed()->where('id', $id)->restore();

        session()->flash('success', 'Post restored successfully');
        return redirect()->route('posts.index');
    }
}
