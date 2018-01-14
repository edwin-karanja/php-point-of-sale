<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Item;

class InventoryController extends AjaxController
{
    public function builder()
    {
        return Inventory::query();
    }

    public function index()
    {
        $data = [
            'items' => Item::with('category')->get()
        ];

        return response()->json($data);
    }

    public function edit(Item $item)
    {
        $data = [
            'inventories' => Inventory::latestFirst()->where('item_id', $item->id)->paginate(10)
        ];

        return response()->json($data);
    }

    public function store(Item $item, Request $request)
    {
        $request->validate([
            'adjustment' => 'required|numeric',
            'comments' => 'required|min:5'
        ]);

        $newQtty = $item->qtty + $request->adjustment;
        $item->quantity()->update(['quantity' => $newQtty]);

        $this->updateInventory($item);

        return response()->json(['success' => true]);
    }

    public function updateInventory($item)
    {
        Inventory::create([
            'item_id' => $item->id,
            'user_id' => auth()->user()->id,
            'comments' => request('comments'),
            'trans_inventory' => request('adjustment')
        ]);
    }
}
