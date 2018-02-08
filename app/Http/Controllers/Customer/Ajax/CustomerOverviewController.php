<?php

namespace App\Http\Controllers\Customer\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerOverviewController extends Controller
{
    public function index(Customer $customer)
    {
        $data = [
            'recentPayment' => $customer->sales()->with('payments')->get()->pluck('payments')->flatten()->sortByDesc('created_at')->first(),
            'balanceDue' => $customer->sales()->withPartialOrZeroPayment()->sum('balance_due')
        ];

        return response()->json($data);
    }
}
