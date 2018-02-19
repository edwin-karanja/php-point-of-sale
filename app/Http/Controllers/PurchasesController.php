<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;

class PurchasesController extends Controller
{
    public function index()
    {
        return view('purchases.index');
    }

    public function recent()
    {
        $purchases = Purchase::latest()->paginate(20);

        return view('purchases.recent', compact('purchases'));
    }
}
