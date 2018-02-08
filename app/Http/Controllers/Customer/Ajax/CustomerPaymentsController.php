<?php

namespace App\Http\Controllers\Customer\Ajax;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\Controller;

class CustomerPaymentsController extends Controller
{
    public function index(Customer $customer)
    {
        $data = [
            'payments' => $customer->sales()->with('payments')->get()->pluck('payments')->flatten()->all()
        ];

        return response()->json($data);
    }
}
