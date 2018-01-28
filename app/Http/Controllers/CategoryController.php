<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public $paginate = 15;

    public function index()
    {
        $categories = Category::paginate($this->paginate);

        return view('category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        Category::create($request->only(['name', 'description']));

        return back()->withSuccess('Category created.');
    }

    public function edit(Category $category)
    {
        $categories = Category::paginate($this->paginate);

        return view('category.index', compact('category', 'categories'));
    }

    public function update(Category $category, Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('categories')->ignore($category->id)
            ]
        ]);

        $category->update($request->only(['name', 'description']));

        return redirect()->route('category.index')->withSuccess("Category {$category->name} updated.");
    }

    public function delete(Category $category)
    {
        $category->items->each->update([
            'category_id' => null
        ]);

        $category->delete();

        return redirect()->route('category.index')->withSuccess("Category {$category->name} deleted!");
    }
}
