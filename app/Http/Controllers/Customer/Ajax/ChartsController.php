<?php

namespace App\Http\Controllers\Customer\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;

class ChartsController extends Controller
{
    public function monthly(Customer $customer)
    {
        $data = [
            'sales' => $customer->sales()->oldest()->month()->get()->pluck('sale_total', 'created_at'),
            'monthlySales' => $customer->sales()
                                ->oldest()
                                ->month()
                                ->selectRaw('DAY(created_at) as month, SUM(sale_total) as revenue')
                                ->groupBy('month')
                                ->pluck('revenue', 'month')
        ];

        return response()->json($data);
    }
}
