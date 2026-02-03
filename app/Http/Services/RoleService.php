<?php

namespace App\Http\Services;

use Throwable;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    public function getAll(int $perPage = 6)
    {
        return Role::with('permissions')->paginate($perPage);
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function store(array $data): Role
    {
        try {
            $role = Role::create(['name' => $data['name']]);
            $this->syncPermissions($role, $data);
            return $role;
        } catch (Throwable $e) {
            throw new \Exception('خطا در ایجاد نقش.', 0, $e);
        }
    }

    public function update(array $data, Role $role): Role
    {
        try {
            $role->update(['name' => $data['name']]);
            $this->syncPermissions($role, $data);
            return $role;
        } catch (Throwable $e) {
            throw new \Exception('خطا در بروزرسانی نقش.', 0, $e);
        }
    }

    public function delete(Role $role)
    {
        if ($role->users()->exists()) {
            throw new \Exception('این نقش به کاربر متصل است و قابل حذف نیست.');
        }

        try {
            $role->delete();
        } catch (Throwable $e) {
            throw new \Exception('خطا در حذف نقش.', 0, $e);
        }
    }

    private function syncPermissions(Role $role, array $data): void
    {
        $permissions = Arr::get($data, 'permissions');

        // فقط وقتی ارسال شده باشد
        if ($permissions !== null) {
            $role->syncPermissions($permissions);
        }
    }
}
