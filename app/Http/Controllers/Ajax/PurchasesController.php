<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Ajax\AjaxController;
use App\Models\Purchase;
use App\Http\Requests\PurchasesStoreRequest;
use App\Models\PurchaseItems;
use App\Models\Item;
use App\Events\QuantityModified;
use App\Events\PricesModified;
use App\Models\Supplier;
use Carbon\Carbon;

class PurchasesController extends AjaxController
{
    public function builder()
    {
        return Purchase::query();
    }

    public function store(PurchasesStoreRequest $request)
    {
        // try {
            $data = $request->only([$request->ref_no]);
            $data['user_id'] = auth()->user()->id;
            $data['supplier_id'] = $request->supplier['id'];

            $purchase = $this->builder->create($data);
            $purchaseTotal = $this->saveTransactionItemsAndComputeTotal($request, $purchase);
            $purchase->update(['purchase_total' => $purchaseTotal]);

            if (isset($request->supplier['id'])) {
                $purchase->supplier()->update([
                    'last_supply_date' => Carbon::now(),
                    'total_supplied_amount' => $purchase->supplier->last_supplied_amount += $purchaseTotal
                ]);
            }

            return response()->json(['success' => true]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => true, 'message' => $e->getMessage()], 302);
        // }
    }

    protected function saveTransactionItemsAndComputeTotal($request, $purchase)
    {
        $purchaseTotal = 0;

        foreach ($request->items as $item) {
            $purchaseTotal += $item['buying_price'] * $item['qtty_purchased'];

            $pItem = [];
            $pItem['item_id'] = $item['id'];
            $pItem['qtty_purchased'] = $item['qtty_purchased'];
            $pItem['buying_price'] = $item['buying_price'];
            $pItem['selling_price'] = $item['selling_price'];
            $pItem['purchase_id'] = $purchase->id;
            PurchaseItems::create($pItem);

            $it = Item::find($item['id']);
            event(new PricesModified($item));

            $oldQtty = $it->qtty;
            $newQtty = $oldQtty + $item['qtty_purchased'];

            event(new QuantityModified($it, auth()->user(), $newQtty , $oldQtty, $purchase, 'Purchase'));
        }

        return $purchaseTotal;

    }
}
