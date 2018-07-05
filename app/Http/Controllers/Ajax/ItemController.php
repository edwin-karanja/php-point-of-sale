<?php

namespace App\Http\Controllers\Ajax;

use Collective\Annotations\Routing\Annotations\Annotations\Delete;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Requests\Ajax\ItemCreateRequest;
use App\Models\Category;
use App\Events\QuantityModified;
use App\Http\Requests\Ajax\ItemUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @Middleware({"web", "auth"})
 * @package App\Http\Controllers\Ajax
 */
class ItemController extends AjaxController
{
    public function builder()
    {
        return Item::query();
    }

    /**
     * @Get("ajax/items", as="item.ajax.index")
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = [
            'items' => Item::getGroupedItems(),
            'columns' => array_values($this->getDisplayableColumns()),
            'customColumns' => $this->setCustomColumnsNames(),
            'createColumns' => $this->setCreateColumns(),
            'displayColumns' => $this->setVisibleColumns(),
            'categories' => Category::all(),
            'admin' => auth()->check() ? auth()->user()->isAdmin() : false
        ];

        return response()->json($data);
    }

    /**
     * @Post("ajax/items", as="item.ajax.store")
     * @param ItemCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ItemCreateRequest $request)
    {
        $data = $request->only(['name', 'description', 'selling_price', 'buying_price', 'reorder_level', 'category_id']);

        $item = $this->builder->create($data);

        event(new QuantityModified($item, $request->user(), $request->qtty));

        return response()->json([
            'success' => true,
            'data' => $item->load(['category', 'quantity'])
        ]);
    }

    /**
     * @Post("ajax/items/{item}", as="item.ajax.update")
     * @param Item $item
     * @param ItemUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Item $item, ItemUpdateRequest $request)
    {
        $data = $request->only(['name', 'description', 'selling_price', 'buying_price', 'reorder_level', 'category_id']);

        $item->update($data);

        $oldQtty = $item->qtty;

        event(new QuantityModified($item->fresh(), $request->user(), $request->qtty, $oldQtty));

        return response()->json([
            'success' => true,
            'data' => $item->load(['category', 'quantity'])
        ]);
    }

    /**
     * @Delete("ajax/items/{id}", as="item.ajax.delete", where={"id": "[0-9]+"})
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->builder->find($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @Post("ajax/items/import", as="item.ajax.import")
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,bin,xls,csv',
        ]);

        try {
            $this->importData($request);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errorMsg' => $e->getMessage()
            ], 500);
        }

        return response()->json(['success' => true]); //@TODO add proper response
    }

    /**
     * @Get("ajax/items/download_sample", as="item.ajax.download_sample")
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download()
    {
        $file = public_path(). "/download/products.xlsx";

        return response()->download($file, 'import_products_template.xlsx');
    }

    public function setCustomColumnsNames()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'selling_price' => 'S.Price',
            'buying_price' => 'B.Price',
            'reorder_level' => 'Reorder Level',
            'category_id' => 'Category',
            'updated_at_human' => 'Last Updated',
            'qtty' => 'Quantity',
            'cat' => 'Category'
        ];
    }

    public function setCreateColumns()
    {
        return [
            'name', 'description', 'buying_price', 'selling_price', 'category_id', 'qtty'
        ];
    }

    public function setVisibleColumns()
    {
        return [
            'name', 'buying_price', 'selling_price', 'qtty', 'description'
        ];
    }

    protected function getDatabaseColumnNames()
    {
        return array_merge(Schema::getColumnListing($this->builder->getModel()->getTable()), $this->builder->getModel()->getAppends());
    }

    public function importData($request)
    {
        Excel::filter('chunk')->load($request->file)
            ->takeColumns(4)
            ->ignoreEmpty()
            ->chunk(50, function($reader) {

            $filtered = $reader->filter(function ($row) {
                return !is_null($row->name);
            });

            foreach($filtered->all() as $product) {

                $item = Item::firstOrCreate(
                    ['name' => $product->name],
                    [
                        'buying_price' => $product->buying ?? 0,
                        'selling_price' => $product->selling ?? 0,
                        'category_id' => Category::firstOrCreate(['name' => $product->category])->id
                    ]
                );

                // event(new QuantityModified($item, $request->user(), 0));
            }
        }, false);
    }
}
