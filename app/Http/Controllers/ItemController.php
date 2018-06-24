<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateItem;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return view('items.index');
    }

    public function getItem(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact(['item', 'categories']));
    }

    public function update(Item $item, UpdateItem $r)
    {
        $item->update([
            'name' => $r->name,
            'description' => $r->description,
            'buying_price' => $r->buying_price,
            'selling_price' => $r->selling_price,
            'reorder_level' => $r->reorder_level,
            'category_id' => $r->category_id,
            'show_on_listing' => $r->show_on_listing == 'on' ? 1 : 0
        ]);

        return redirect()->back()->withSuccess('Item details updated');
    }

    public function auditItem(Item $item)
    {
        $audits = $item->audits;
        return view('items.audit', compact('audits'));
    }

    public function getSuppliers(Item $item)
    {
        return view('items.suppliers', compact('item'));
    }
}
