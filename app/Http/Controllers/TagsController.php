<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Tag;


class TagsController extends Controller
{

    public function index()
    {
        return view('tags.index')->with('tags', Tag::all());
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(TagRequest $request)
    {

        Tag::create([
            'name' => $request->name
        ]);

        session()->flash('success', 'Tag created successfully');

        return redirect()->route('tags.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Tag $tag)
    {
        return view('tags.create')->with('tag', $tag);
    }

    public function update($request, Tag $tag)
    {
        $tag->update([
            'name' => $request->name
        ]);

        session()->flash('success', 'Tag updated successfully');

        return redirect()->route('tags.index');
    }

    public function destroy(Tag $tag)
    {
        if($tag->posts->count() > 0) {
            session()->flash('error', "Tag can't be deleted, because it is associated to post(s).");
            return redirect()->back();
        }

        $tag->delete();
        session()->flash('success', 'Tag deleted successfully');
        return redirect()->route('tags.index');
    }
}
