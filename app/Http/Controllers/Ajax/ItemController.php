<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Requests\Ajax\ItemCreateRequest;
use App\Models\Category;
use App\Events\QuantityModified;
use App\Http\Requests\Ajax\ItemUpdateRequest;

class ItemController extends AjaxController
{
    public function builder()
    {
        return Item::query();
    }

    public function index()
    {
        $data = [
            'items' => $this->builder->with(['category', 'quantity'])->get(),
            'columns' => array_values($this->getDisplayableColumns()),
            'customColumns' => $this->setCustomColumnsNames(),
            'createColumns' => $this->setCreateColumns(),
            'displayColumns' => $this->setVisibleColumns(),
            'categories' => Category::all()
        ];

        return response()->json($data);
    }

    public function store(ItemCreateRequest $request)
    {
        $data = $request->only(['name', 'decsription', 'selling_price', 'buying_price', 'reorder_level', 'category_id']);

        $item = $this->builder->create($data);

        event(new QuantityModified($item, $request->user(), $request->qtty));

        return response()->json([
            'success' => true
        ]);
    }

    public function update(Item $item, ItemUpdateRequest $request)
    {
        $data = $request->only(['name', 'decsription', 'selling_price', 'buying_price', 'reorder_level', 'category_id']);

        $item->update($data);

        $oldQtty = $item->qtty;

        event(new QuantityModified($item->fresh(), $request->user(), $request->qtty, $oldQtty));

        return response()->json([
            'success' => true
        ]);
    }

    public function delete($id)
    {
        $this->builder->find($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function setCustomColumnsNames()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'selling_price' => 'Selling Price',
            'buying_price' => 'Buying Price',
            'reorder_level' => 'Reorder Level',
            'category_id' => 'Category',
            'updated_at_human' => 'Last Updated',
            'qtty' => 'Quantity'
        ];
    }

    public function setCreateColumns()
    {
        return [
            'name', 'description', 'buying_price', 'selling_price', 'reorder_level', 'category_id', 'qtty'
        ];
    }

    public function setVisibleColumns()
    {
        return [
            'name', 'buying_price', 'selling_price', 'reorder_level', 'category_id', 'qtty', 'updated_at_human'
        ];
    }

    protected function getDatabaseColumnNames()
    {
        return array_merge(Schema::getColumnListing($this->builder->getModel()->getTable()), $this->builder->getModel()->getAppends());
    }
}
