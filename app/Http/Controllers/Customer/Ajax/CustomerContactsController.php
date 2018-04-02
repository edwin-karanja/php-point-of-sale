<?php

namespace App\Http\Controllers\Customer\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Http\Controllers\Ajax\AjaxController;
use Illuminate\Validation\Rule;

class CustomerContactsController extends AjaxController
{
    public function builder()
    {
        return Customer::query();
    }

    public function index(Customer $customer)
    {
        $data = [
            'contacts' => $customer->contacts,
            'columns' => $this->setContactsColumns(),
            'customColumns' => $this->setCustomColumns()
        ];

        return response()->json($data);
    }

    public function store(Customer $customer, Request $request)
    {
        $request->validate([
            'contact_name' => 'required',
            'contact_email' => 'required|email|unique:customer_contacts',
            'contact_phone' => 'required|numeric|unique:customer_contacts'
        ]);

        $contact = new CustomerContact($request->only(['contact_name', 'contact_email', 'contact_phone']));

        $customer->contacts()->save($contact);

        return response()->json([
            'success' => true
        ]);
    }

    public function update(Customer $customer, Request $request, CustomerContact $contact)
    {
        $request->validate([
            'contact_name' => 'required',
            'contact_email' => [
                'required',
                Rule::unique('customer_contacts')->ignore($contact->id)
            ],
            'contact_phone' => [
                'required',
                Rule::unique('customer_contacts')->ignore($contact->id)
            ]
        ]);

        $contact->update(
            $request->only(['contact_name', 'contact_email', 'contact_phone'])
        );

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(Customer $customer, CustomerContact $contact)
    {
        if ($contact->customer && $contact->customer->id === $customer->id) {
            $contact->delete();
        }

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
