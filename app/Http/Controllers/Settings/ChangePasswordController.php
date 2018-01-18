<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\Oldpassword;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('settings.change_password', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'old_password' => [
                'required', new Oldpassword],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->withSuccess('Password changed successfully.');
    }
}
