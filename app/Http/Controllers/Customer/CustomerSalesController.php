<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\Controller;

class CustomerSalesController extends Controller
{
    public function index(Customer $customer)
    {
        $customer->load('sales');

        return view('customer.account', compact('customer'));
    }
}
