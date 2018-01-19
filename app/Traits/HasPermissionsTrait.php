<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;


trait HasPermissionsTrait
{
    public function giveRole(...$roles)
    {
        $roles = $this->getRoles(array_flatten($roles));

        if ($roles === null) {
            return $this;
        }

        $this->roles()->saveMany($roles);

        return $this;
    }

    public function updateRoles(...$roles)
    {
        $this->roles()->detach();

        return $this->giveRole($roles);
    }

    public function withdrawRole(...$roles)
    {
        $roles = $this->getRoles(array_flatten($roles));

        $this->roles()->detach($roles);

        return $this;
    }

    public function getRoles(array $roles)
    {
        return Role::whereIn('name', $roles)->get();
    }

    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getPermissions(array_flatten($permissions));

        if ($permissions === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    public function withdrawPermissionsTo(...$permissions)
    {
        $permissions = $this->getPermissions(array_flatten($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    public function updatePermissions(...$permissions)
    {
        $this->$permissions()->detach();

        return $this->givePermissionsTo($permissions);
    }

    protected function getPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    public function hasRole(...$roles)
    {
        foreach($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }

        return false;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }
}