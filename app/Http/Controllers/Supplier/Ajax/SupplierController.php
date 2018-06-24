<?php

namespace App\Http\Controllers\Supplier\Ajax;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Requests\Ajax\StoreSupplierRequest;

class SupplierController extends AjaxController
{
    public function builder()
    {
        return Supplier::query();
    }

    public function index()
    {
        $data = [
            'suppliers' => $this->builder->get(),
            'columns' => array_values($this->getDisplayableColumns()),
            'customColumns' => $this->setCustomColumnsNames(),
            'createColumns' => $this->setCreateColumns(),
            'displayColumns' => $this->setVisibleColumns()
        ];

        return response()->json($data);
    }

    public function store(StoreSupplierRequest $request)
    {
        $this->builder->create($request->only(['name', 'description', 'vat_pin']));

        return response()->json([
            'success' => true
        ]);
    }

    protected function setCustomColumnsNames()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'contact_info' => 'Contact Info',
            'vat_pin' => 'Vat PIN'
        ];
    }

    protected function setCreateColumns()
    {
        return ['name', 'contact_info', 'vat_pin', 'description'];
    }

    protected function setVisibleColumns()
    {
        return ['name', 'description', 'contact_info', 'vat_pin'];
    }
}
