<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Ajax\AjaxController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends AjaxController
{
    public function builder()
    {
        return Customer::query();
    }

    public function index()
    {
        $data = [
            'customers' => $this->builder->get(),
            'columns' => array_values($this->getDisplayableColumns()),
            'customColumns' => $this->setCustomColumnsNames(),
            'createColumns' => $this->setCreateColumns(),
            'displayColumns' => $this->setVisibleColumns()
        ];

        return response()->json($data);
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->only(['name', 'gender', 'telephone', 'email']);

        $this->builder->create($data);

        return response()->json(['success' => true]);
    }

    public function update(Customer $customer, UpdateCustomerRequest $request)
    {
        $data = $request->only(['name', 'gender', 'telephone', 'email']);

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

    public function setCustomColumnsNames()
    {
        return [
            'name' => 'Name',
            'gender' => 'Gender',
            'picture' => 'Picture',
            'telephone' => 'Telephone',
            'email' => 'Email',
            'comments' => 'Comments'
        ];
    }

    public function setCreateColumns()
    {
        return [
            'name', 'gender', 'telephone', 'email'
        ];
    }

    public function setVisibleColumns()
    {
        return [
            'name', 'gender', 'telephone', 'email'
        ];
    }
}
