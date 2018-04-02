<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            return new CategoryCollection(Category::where('name', 'LIKE', "%$search%")->withCount('items')->get());
        }

        return new CategoryCollection(Category::withCount('items')->paginate(10));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        Category::create($request->only(['name', 'description']));

        return response()->json([
            'success' => true
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('categories')->ignore($category->id)
            ]
        ]);

        $category->update(
            $request->only(['name', 'description'])
        );

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category) {
            $category->delete();
        }
    }

}
