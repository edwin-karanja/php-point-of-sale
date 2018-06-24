<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemSuppliersController extends Controller
{
    public function index(Item $item)
    {
        $itemSupplierIds = $item->suppliers->pluck('id')->all();
        return response()->json([
            'all' => Supplier::whereNotIn('id', $itemSupplierIds)->get()
        ]);
    }

    public function store(Item $item, Request $request)
    {
        $supplier = Supplier::find($request->id);
        $item->suppliers()->attach($supplier);

        return response()->json([
            'success' => true
        ]);
    }
}
