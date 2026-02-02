<?php

namespace App\Http\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function store(array $data)
    {
        $role = Role::create(['name' => $data['name']]);
        if (isset($data['permissions']) && !empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return $role;
    }

    public function update(array $data, Role $role)
    {
        $role->update(['name' => $data['name']]);
        // attach + detach اتوماتیک
        $role->syncPermissions($data['permissions']);
    }
}
