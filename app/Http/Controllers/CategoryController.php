<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{

    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {

        Category::create([
            'name' => $request->name
        ]);

        session()->flash('success', 'Category created successfully');

        return redirect()->route('categories.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('categories.create')->with('category', $category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name
        ]);

        session()->flash('success', 'Category updated successfully');

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        if($category->posts->count() > 0) {
            session()->flash('error', "Category can't be deleted, because it is associated to post(s).");
            return redirect()->back();
        }

        $category->delete();
        session()->flash('success', 'Category deleted successfully');
        return redirect()->route('categories.index');
    }
}
