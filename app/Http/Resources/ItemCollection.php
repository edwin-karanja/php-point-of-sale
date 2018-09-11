<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'fields' => $this->fields()
        ];
    }

    public function fields()
    {
        return [
            'name',
            'selling_price',
            'buying_price',
            'description',
            'qtty'
        ];
    }
}
