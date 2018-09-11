<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::filter( $request );

        return new ItemCollection( $items->paginate() );
    }

    public function show(Item $item)
    {
        return new ItemResource( $item );
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted'
        ]);
    }

    public function restore($id)
    {
        $item = Item::withTrashed()->findOrFail($id);

        if ($item->trashed()) {
            $item->restore();

            return response()->json(['success' => true, 'message' => 'Item restored']);
        }
    }
}
