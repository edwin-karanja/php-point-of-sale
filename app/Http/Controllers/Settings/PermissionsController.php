<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return view('settings.permissions.index', compact('permissions'));
    }

    public function edit(Permission $permission)
    {
        return view('settings.permissions.edit', compact('permission'));
    }

    public function create()
    {
        return view('settings.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions'
        ]);

        Permission::create($request->only(['name']));

        return redirect()->route('settings.permissions.index')->withSuccess('Permission created');
    }

    public function update(Permission $permission, Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('permissions')->ignore($permission->id)]
        ]);

        $permission->update($request->only(['name']));

        return redirect()->route('settings.permissions.index')->withSuccess('Permission updated');
    }
}
