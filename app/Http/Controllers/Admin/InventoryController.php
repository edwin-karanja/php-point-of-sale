<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\InventoryResource;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    public function index(Item $item)
    {
        $inv = $item->inventory();

        return InventoryResource::collection( $inv->paginate(2) );
    }
}
