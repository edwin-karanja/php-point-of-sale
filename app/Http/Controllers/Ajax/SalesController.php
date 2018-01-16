<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Ajax\AjaxController;
use App\Models\Sale;
use App\Http\Requests\SaleStoreRequest;
use App\Models\SaleItems;
use App\Events\QuantityModified;
use App\Models\Item;

class SalesController extends AjaxController
{
    public function builder()
    {
        return Sale::query();
    }

    public function store(SaleStoreRequest $request)
    {
        $data = $this->prepareSaleData($request);
        $sale = Sale::create($data);

        $saleTotal = $this->storeSaleItemsAndComputeSalesTotal($request, $sale);

        $sale->update(['sale_total' => $saleTotal]);

        return response()->json(['success' => true]);

    }

    protected function prepareSaleData($request) {
        $data = [];

        $data['payment_mode'] = request('payment_mode');
        $data['customer_id'] = $request->customer['id'];
        $data['user_id'] = auth()->user()->id;
        $data['mpesa_ref_no'] = $request->mpesa_ref;

        return $data;
    }

    protected function storeSaleItemsAndComputeSalesTotal($request, $sale)
    {
        $saleTotal = 0;

        foreach ($request->items as $item) {
            $saleTotal += $item['selling_price'] * $item['qtty_sold'];

            $itemData['item_id'] = $item['id'];
            $itemData['qtty_sold'] = $item['qtty_sold'];
            $itemData['buying_price'] = $item['buying_price'];
            $itemData['selling_price'] = $item['selling_price'];
            $itemData['sale_id'] = $sale->id;
            SaleItems::create($itemData);

            $it = Item::find($item['id']);
            $oldQtty = $it->qtty;
            $newQtty = $oldQtty - $item['qtty_sold'];

            event(new QuantityModified($it, auth()->user(), $newQtty , $oldQtty, $sale, 'Sale'));
        }

        return $saleTotal;
    }


}
