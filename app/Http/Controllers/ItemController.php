<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateItem;
use App\Models\Category;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Supplier;

/**
 * @Middleware({"web", "auth"})
 * @package App\Http\Controllers
 */
class ItemController extends Controller
{
    /**
     * @Get("items", as="item.index")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('items.index');
    }

    /**
     * @Get("items/{item}", as="item.edit")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact(['item', 'categories']));
    }

    /**
     * @Post("items/{item}/update", as="item.update")
     * @return mixed
     */
    public function update(Item $item, UpdateItem $r)
    {
        $item->update([
            'name' => $r->name,
            'description' => $r->description,
            'buying_price' => $r->buying_price,
            'selling_price' => $r->selling_price,
            'reorder_level' => $r->reorder_level,
            'category_id' => $r->category_id,
            'show_on_listing' => $r->show_on_listing === 'on' ? 1 : 0
        ]);

        return redirect()->back()->withSuccess('Item details updated');
    }

    /**
     * @Get("items/{item}/audit", as="item.audit")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function auditItem(Item $item)
    {
        $audits = $item->audits;
        return view('items.audit', compact('audits'));
    }

    /**
     * @Get("items/{item}/suppliers", as="item.supplier")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSuppliers(Item $item)
    {
        $suppliers = Supplier::all();

        return view('items.suppliers', compact('item', 'suppliers'));
    }
}
