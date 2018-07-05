<?php

namespace App\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Illuminate\Http\Request;
use App\Models\Item;

/**
 * @Middleware({"web", "auth"})
 */
class InventoryController extends Controller
{
    /**
     * @Get("inventory")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('inventory.index');
    }
}
