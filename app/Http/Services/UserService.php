<?php

namespace App\Http\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\UserDeleteException;

class UserService
{
    /**
     * گرفتن همه کاربران paginate شده
     */
    public function getAll(int $perPage = 10)
    {
        return User::with('roles')->paginate($perPage);
    }

    /**
     * ایجاد یک کاربر جدید
     */
    public function create(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (!empty($data['roles'])) {
            $roles = Role::whereIn('name', $data['roles'])->get();
            $user->syncRoles($roles);
        }

        return $user;
    }

    /**
     * به‌روزرسانی کاربر
     */
    public function update(User $user, array $data): User
    {
        if (blank($data['password'] ?? null)) {
            unset($data['password'], $data['password_confirmation']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $roles = Arr::pull($data, 'roles', []);
        $user->update($data);
        $user->syncRoles($roles);

        return $user;
    }

    /**
     * حذف کاربر
     */
    public function delete(User $user): void
    {
        try {
            if (! $user->exists) {
                throw new UserDeleteException('کاربر مورد نظر وجود ندارد.');
            }

            if (! $user->delete()) {
                throw new UserDeleteException('حذف کاربر با خطا مواجه شد.');
            }

        } catch (Exception $e) {
            throw new UserDeleteException(
                'خطایی در فرآیند حذف کاربر رخ داد.'
            );
        }
    }
}
