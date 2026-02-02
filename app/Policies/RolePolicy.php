<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * دسترسی کامل برای Admin یا Super-admin از گارد admin
     */
    public function before($user, $ability)
    {
        if ($user instanceof Admin) {
            return true;
        }
    }

    /**
     * همه کاربران لاگین شده با نقش مناسب می‌توانند لیست نقش‌ها را ببینند
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('super-admin|admin'); // در اینجا web guard است
    }

    /**
     * مشاهده یک Role
     */
    public function view(User $user, Role $role)
    {
        return $user->hasRole('super-admin|admin');
    }

    /**
     * ایجاد Role جدید
     */
    public function create(User $user)
    {
        return $user->hasRole('super-admin|admin');
    }

    /**
     * ویرایش یک Role
     */
    public function update(User $user, Role $role)
    {
        return $user->hasRole('super-admin|admin');
    }

    /**
     * حذف Role
     */
    public function delete(User $user, Role $role)
    {
        return $user->hasRole('super-admin|admin');
    }
}
