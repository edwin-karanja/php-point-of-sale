<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    protected $auth;

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->auth = auth('api');
    }

    public function index()
    {
        $items = Item::with('category', 'quantity')->get();

        return ItemResource::collection( $items );
    }

}
