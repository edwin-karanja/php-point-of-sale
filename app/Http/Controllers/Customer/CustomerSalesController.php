<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\Controller;

class CustomerSalesController extends Controller
{
    public function index(Customer $customer)
    {
        $recentSale = $customer->sales()->withPayment()->recent()->first();
        $balanceDue = $customer->sales()->withPartialOrZeroPayment()->sum('balance_due');

        return view('customer.account', compact('customer', 'recentSale', 'balanceDue'));
    }
}
