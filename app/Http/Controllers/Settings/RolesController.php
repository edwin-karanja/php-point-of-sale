<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Validation\Rule;
use App\Models\Permission;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('settings.roles.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        return view('settings.roles.edit', compact('role'));
    }

    public function update(Role $role, Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('roles')->ignore($role->id)]
        ]);

        $role->update($request->only(['name']));

        return redirect()->route('settings.roles.index')->withSuccess('Role updated');
    }

    public function create()
    {
        return view('settings.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        Role::create($request->only(['name']));

        return redirect()->route('settings.roles.index')->withSuccess('New role created');
    }

    public function assign(Role $role)
    {
        $permissions = Permission::all();
        $role_perms = $role->permissions->pluck('name')->toArray();

        return view('settings.roles.assign', compact('role', 'permissions', 'role_perms'));
    }

    public function assignPermissions(Role $role, Request $request)
    {
        foreach($request->except('_token') as $key => $perm) {
            $perms[] = str_replace('_', ' ', $key);
        }

        $role->updatePermissions($perms);

        return redirect()->route('settings.roles.index')->withSuccess('Role permissions updated');
    }
}
