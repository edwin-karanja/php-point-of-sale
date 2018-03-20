<?php

namespace App\Http\Controllers\Settings;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $storeSettings = Setting::all();

        return view('settings.store.index', compact('storeSettings'));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
