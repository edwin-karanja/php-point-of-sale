<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierProfileController extends Controller
{
    public function index(Supplier $supplier)
    {
        return view('supplier.profile', compact('supplier'));
    }
}
