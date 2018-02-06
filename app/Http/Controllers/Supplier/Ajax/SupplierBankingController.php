<?php

namespace App\Http\Controllers\Supplier\Ajax;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Controllers\Ajax\AjaxController;
use App\Models\SupplierMeta;

class SupplierBankingController extends AjaxController
{
    public function builder()
    {
        return Supplier::query();
    }

    public function index(Supplier $supplier)
    {
        $data = [
            'bankings' => $supplier->meta()->select('id', 'bank_name', 'bank_account_number')->get(),
            'columns' => $this->setBankingsColumns(),
            'customColumns' => $this->setCustomColumns()
        ];

        return response()->json($data);
    }

    public function store(Supplier $supplier, Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'bank_account_number' => 'required|numeric|unique:supplier_metas'
        ]);

        $meta = new SupplierMeta($request->only(['bank_name', 'bank_account_number']));

        $supplier->meta()->save($meta);

        return response()->json([
            'success' => true
        ]);
    }

    protected function setBankingsColumns()
    {
        return [
            'bank_name',
            'bank_account_number'
        ];
    }

    protected function setCustomColumns()
    {
        return [
            'bank_name' => 'Bank Name',
            'bank_account_number' => 'Account Number'
        ];
    }
}
