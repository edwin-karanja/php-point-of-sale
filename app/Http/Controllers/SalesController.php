<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class SalesController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }

    public function recent(Request $request)
    {
        $sales = Sale::filter($request)->latest()->withCount('items')->paginate(20);

        return view('sales.recent', compact('sales'));
    }
}
