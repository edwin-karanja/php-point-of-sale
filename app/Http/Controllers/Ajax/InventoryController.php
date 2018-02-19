<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Quantity;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Rules\PositiveValue;

class InventoryController extends AjaxController
{
    public function builder()
    {
        return Inventory::query();
    }

    public function index()
    {
        $data = [
            'items' => Item::updatesFirst()->with('category')->get()
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
            'adjustment' => ['required','numeric', new PositiveValue($item)],
            'comments' => 'required|min:5'
        ]);

        $newQtty = $item->qtty + $request->adjustment;

        Quantity::updateOrCreate(
            ['item_id' => $item->id],
            ['quantity' => $newQtty]
        );

        $this->updateInventory($item);

        return response()->json(['success' => true]);
    }

    public function updateInventory($item)
    {
        Inventory::create([
            'item_id' => $item->id,
            'user_id' => auth()->user()->id,
            'comments' => request('comments'),
            'trans_inventory' => request('adjustment'),
            'trans_date' => Carbon::now()
        ]);
    }
}
