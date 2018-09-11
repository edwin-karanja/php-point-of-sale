<?php

namespace App\Http\Controllers\Ajax;

use App\Helpers\Cache\ItemsCache;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Quantity;
use Carbon\Carbon;
use App\Rules\PositiveValue;

/**
 * @Middleware({"web", "auth"})
 */
class InventoryController extends AjaxController
{
    protected $cache;

    public function __construct(ItemsCache $cache)
    {
        parent::__construct();

        $this->cache = $cache;
    }

    public function builder()
    {
        return Inventory::query();
    }

    /**
     * @Get("ajax/inventory")
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index()
    {
        $data = [
            'items' => $this->cache->getCache('inventory-items')
        ];

        return response()->json($data);
    }

    /**
     * @Get("ajax/inventory/{item}")
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse)
     */
    public function edit(Item $item)
    {
        $data = [
            'inventories' => Inventory::latestFirst()->where('item_id', $item->id)->paginate(10)
        ];

        return response()->json($data);
    }

    /**
     * @Post("ajax/inventory/{item}/adjust")
     * @param Item $item
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Update the inventory data for a particular item.
     * @param $item
     */
    private function updateInventory($item)
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
