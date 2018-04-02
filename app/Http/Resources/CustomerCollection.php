<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Schema;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'customers' => $this->collection,
            'columns' => array_values($this->displayableColumns()),
            'customColumns' => $this->customColumnsNames(),
            'createColumns' => $this->createColumns(),
            'displayColumns' => $this->visibleColumns(),
            'allow' => $this->setPermissions()
        ];
    }

    protected function customColumnsNames()
    {
        return [
            'name' => 'Name',
            'picture' => 'Picture',
            'telephone' => 'Telephone',
            'email' => 'Email',
            'comments' => 'Comments'
        ];
    }

    protected function createColumns()
    {
        return [
            'name', 'telephone', 'email'
        ];
    }

    protected function visibleColumns()
    {
        return [
            'name', 'telephone', 'email'
        ];
    }

    protected function setPermissions()
    {
        return [
            'creation' => auth()->user()->isAdmin(),
            'deletion' => auth()->user()->isAdmin(),
        ];
    }

    protected function displayableColumns()
    {
        return array_diff($this->getDatabaseColumnNames(), Customer::query()->getModel()->getHidden());
    }

    protected function getDatabaseColumnNames()
    {
        return Schema::getColumnListing(Customer::query()->getModel()->getTable());
    }
}
