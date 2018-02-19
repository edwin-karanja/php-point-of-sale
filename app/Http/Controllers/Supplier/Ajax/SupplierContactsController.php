<?php

namespace App\Http\Controllers\Supplier\Ajax;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Controllers\Ajax\AjaxController;
use App\Models\SupplierContact;

class SupplierContactsController extends AjaxController
{
    public function builder()
    {
        return Supplier::query();
    }

    public function index(Supplier $supplier)
    {
        $data = [
            'contacts' => $supplier->contacts,
            'columns' => $this->setContactsColumns(),
            'customColumns' => $this->setCustomColumns()
        ];

        return response()->json($data);
    }

    public function store(Supplier $supplier, Request $request)
    {
        $request->validate([
            'contact_name' => 'required',
            'contact_email' => 'required|email|unique:supplier_contacts',
            'contact_phone' => 'required|numeric|unique:supplier_contacts'
        ]);

        $contact = new SupplierContact($request->only(['contact_name', 'contact_email', 'contact_phone']));

        $supplier->contacts()->save($contact);

        return response()->json([
            'success' => true
        ]);
    }

    protected function setContactsColumns()
    {
        return [
            'contact_name',
            'contact_email',
            'contact_phone'
        ];
    }

    protected function setCustomColumns()
    {
        return [
            'contact_phone' => 'Phone',
            'contact_email' => 'Email',
            'contact_name' => 'Name'
        ];
    }
}
