<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\Settings\CreateUserRequest;
use App\Http\Requests\Settings\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::all();

        return view('settings.users.index', compact('users'));
    }

    public function create()
    {
        return view('settings.users.add');
    }

    public function store(CreateUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('settings.users.index')->withSuccess('New User Created.');
    }

    public function edit(User $user)
    {
        return view('settings.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('settings.users.index')->withSuccess('User Updated Successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('settings.users.index')->withSuccess("User {$user->name} deleted");
    }
}
