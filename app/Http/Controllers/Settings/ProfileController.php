<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\Settings\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('settings.profile', compact('user'));
    }

    public function store(UpdateProfileRequest $request)
    {
        auth()->user()->update(
            $request->only([
                'name', 'email', 'gender'
            ])
        );

        return back()->withSuccess('Account details successfully updated!');
    }
}
