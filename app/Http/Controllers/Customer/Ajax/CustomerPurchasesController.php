<?php

namespace App\Http\Controllers\Customer\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payments;

class CustomerPurchasesController extends Controller
{
    public function index(Customer $customer)
    {
        $data = [
            'purchases' => $customer->sales()->recent()->paginate(15)
        ];

        return response()->json($data);
    }

    public function store(Request $request, Customer $customer, $id)
    {
        $request->validate([
            'pay' => 'required|numeric'
        ]);

        $sale = $customer->sales()->find($id);
        $amount_paid = $sale->amount_paid += $request->pay;
        $sale->update([
            'amount_paid' => $amount_paid,
            'balance_due' => $sale->sale_total - $amount_paid
        ]);
        $sale->updatePaymentStatus();

        Payments::create([
            'sale_id' => $id,
            'amount_paid' => $request->pay
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
