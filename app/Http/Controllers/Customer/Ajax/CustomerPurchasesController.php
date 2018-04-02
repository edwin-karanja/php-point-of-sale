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
            'purchases' => $customer->sales()->with(['payments', 'items'])->recent()->paginate(15)
        ];

        return response()->json($data);
    }

    public function store(Request $request, Customer $customer, $id)
    {
        $request->validate([
            'pay' => 'required|numeric'
        ]);

        $sale = $customer->sales()->find($id);
        $expectedAmount = $sale->balance_due;
        $amount = $request->pay > $expectedAmount ? $expectedAmount : $request->pay;

        $amount_paid = $sale->amount_paid += $amount;
        $sale->update([
            'amount_paid' => $amount_paid,
            'balance_due' => $sale->sale_total - $amount_paid
        ]);
        $sale->updatePaymentStatus();

        $lastPay = $sale->payments()->latest()->first();

        Payments::create([
            'sale_id' => $id,
            'amount_paid' => $amount,
            'balance_due' => $lastPay->balance_due - $amount
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
