<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Collective\Annotations\Routing\Annotations\Annotations\Delete;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

/**
 * @Middleware({"web", "auth"})
 */
class CategoriesController extends Controller
{
    /**
     * @Get("ajax/categories", as="ajax.categories.index")
     *
     * @param Request $request
     * @return CategoryCollection
     */
    public function index(Request $request)
    {
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            return new CategoryCollection(Category::latest()->where('name', 'LIKE', "%$search%")->withCount('items')->get());
        }

        return new CategoryCollection(Category::latest()->withCount('items')->paginate(15));
    }

    /**
     * @Post("ajax/categories", as="ajax.categories.store")
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @Put("ajax/categories/{category}")
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @Delete("ajax/categories/{category}")
     *
     * @param Category $category
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if ($category) {
            $category->delete();
        }
    }

}
