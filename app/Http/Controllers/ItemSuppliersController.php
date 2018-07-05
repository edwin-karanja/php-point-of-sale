<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Illuminate\Http\Request;

/**
 * @Middleware({"web", "auth"})
 * @package App\Http\Controllers
 */
class ItemSuppliersController extends Controller
{
    /**
     * @Get("items/{item}/suppliers/show")
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Item $item)
    {
        $itemSupplierIds = $item->suppliers->pluck('id')->all();
        return response()->json([
            'all' => Supplier::whereNotIn('id', $itemSupplierIds)->get()
        ]);
    }

    /**
     * @Post("items/{item}/suppliers/attach")
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Item $item, Request $request)
    {
        $supplier = Supplier::find($request->id);
        $item->suppliers()->attach($supplier);

        return response()->json([
            'success' => true
        ]);
    }
}
