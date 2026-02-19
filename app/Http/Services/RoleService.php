<?php

namespace App\Http\Services;

use App\Exceptions\InvalidGuardException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Exceptions\RoleHasUsersException;

class RoleService
{
    public function getAll(int $perPage = 6)
    {
        return Role::with('permissions')->paginate($perPage);
    }

    public function getAllPermissions(string $guard = 'admin'): Collection
    {
        return Permission::where('guard_name', $guard)->get();
    }

    public function store(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $role = Role::create([
                'name' => $data['name'],
                'guard_name' => $data['guard_name']
                ]);
            $this->syncPermissions($role, $data);
            return $role;
        });
    }

    public function update(array $data, Role $role): Role
    {
        return DB::transaction(function () use ($data, $role) {
            $role->update(['name' => $data['name']]);
            $this->syncPermissions($role, $data);
            return $role;
        });
    }

    public function delete(Role $role): void
    {
        if ($role->users()->exists()) {
            throw new RoleHasUsersException('این نقش به کاربر متصل است و قابل حذف نیست.');
        }

        $role->delete();
    }

    private function syncPermissions(Role $role, array $data): void
    {
        $permissions = Arr::get($data, 'permissions', []);
        $role->syncPermissions($permissions);
    }


    public function permissionsForGuard(string $guard)
    {
        if (!array_key_exists($guard, config('auth.guards'))) {
            throw new InvalidGuardException("Invalid guard: {$guard}");
        }

        return \Spatie\Permission\Models\Permission::where('guard_name', $guard)
            ->select('id', 'name')
            ->get();
    }
}
