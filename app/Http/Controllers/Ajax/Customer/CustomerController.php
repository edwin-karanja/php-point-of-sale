<?php

namespace App\Http\Controllers\Ajax\Customer;

use App\Http\Resources\CustomerCollection;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        return new CustomerCollection(Customer::latest()->get());
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->only(['name', 'gender', 'telephone', 'email']);

        $this->builder->create($data);

        return response()->json(['success' => true]);
    }

    public function update(Customer $customer, UpdateCustomerRequest $request)
    {
        $data = $request->only(['name', 'telephone', 'email']);

        $customer->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $this->builder->find($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
