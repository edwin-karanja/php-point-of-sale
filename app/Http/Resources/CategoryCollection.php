<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
            'data' => $this->collection,
            'displayColumns' => $this->displayColumns(),
            'customColumns' => $this->customColumns(),
            'allow' => $this->setPermissions(),
            'updatable' => $this->updatable(),
            'columnTypes' => $this->columnTypes(),
            'searching' => $this->searchSettings()
        ];
    }

    protected function displayColumns()
    {
        return [
            'name', 'description', 'items_count'
        ];
    }

    protected function customColumns()
    {
        return [
            'items_count' => 'Items Count'
        ];
    }

    protected function columnTypes()
    {
        return [
            'name' => 'text',
            'description' => 'textarea'
        ];
    }

    protected function setPermissions()
    {
        return [
            'creation' => auth()->user()->isAdmin(),
            'deletion' => auth()->user()->isAdmin(),
        ];
    }

    protected function searchSettings()
    {
        return [
            'allowed' => true,
            'type' => 'backend',
        ];
    }

    protected function updatable()
    {
        return [
            'name', 'description'
        ];
    }
}
