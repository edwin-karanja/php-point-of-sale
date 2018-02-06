<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierMetaController extends Controller
{
    public function index(Supplier $supplier)
    {
        return view('supplier.meta', compact('supplier'));
    }
}
