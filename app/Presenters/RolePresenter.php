<?php

namespace App\Presenters;

use Spatie\Permission\Models\Role;

class RolePresenter
{
    protected Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function editRoute(): string
    {
        return auth()->guard('admin')->check()
            ? route('admin.roles.edit', $this->role->id)
            : route('roles.edit', $this->role->id);
    }

    public function destroyRoute(): string
    {
        return auth()->guard('admin')->check()
            ? route('admin.roles.destroy', $this->role->id)
            : route('roles.destroy', $this->role->id);
    }

    public function name(): string
    {
        return $this->role->name;
    }

    public function permissions(): \Illuminate\Support\Collection
    {
        return $this->role->permissions;
    }
}
