<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\Settings\CreateStoreConfigsRequest;
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
        $store = Setting::first() ?: new Setting();

        return view('settings.store.index', compact('store'));
    }

    public function store(CreateStoreConfigsRequest $request)
    {
        $store = Setting::updateOrCreate(
            ['name' => $request->name],
            ['short_name' => $request->short_name,
            'location' => $request->location,
            'address' => $request->address,
            'timezone' => $request->timezone,
            'tax_percent' => $request->tax_percent,
            'receipt_contents' => $request->receipt_contents]
        );

        if ($request->has('picture')) {
            $store->addMediaFromRequest('picture')->toMediaCollection('store-image');
        }

        return redirect()->route('settings.store.index')->withSuccess('Store Settings saved.');
    }
}
