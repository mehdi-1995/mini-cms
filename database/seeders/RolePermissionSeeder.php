<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // پاک کردن کش پکیج
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // تعریف permission ها برای هر دو گارد
        $permissions = [
            // Admin guard
            ['name' => 'view posts',    'guard_name' => 'admin'],
            ['name' => 'create posts',  'guard_name' => 'admin'],
            ['name' => 'edit own posts','guard_name' => 'admin'],
            ['name' => 'edit all posts','guard_name' => 'admin'],
            ['name' => 'delete posts',  'guard_name' => 'admin'],
            ['name' => 'publish posts', 'guard_name' => 'admin'],
            ['name' => 'manage users',  'guard_name' => 'admin'],
            ['name' => 'assign roles',  'guard_name' => 'admin'],

            // Web guard
            ['name' => 'view posts',    'guard_name' => 'web'],
            ['name' => 'create posts',  'guard_name' => 'web'],
            ['name' => 'edit own posts','guard_name' => 'web'],
            ['name' => 'edit all posts','guard_name' => 'web'],
            ['name' => 'delete posts',  'guard_name' => 'web'],
            ['name' => 'publish posts', 'guard_name' => 'web'],
        ];

        // ساخت permission ها
        foreach ($permissions as $perm) {
            Permission::firstOrCreate($perm);
        }

        // ساخت نقش‌ها
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin',       'guard_name' => 'admin']);
        $editor     = Role::firstOrCreate(['name' => 'editor',      'guard_name' => 'web']);
        $author     = Role::firstOrCreate(['name' => 'author',      'guard_name' => 'web']);
        $user       = Role::firstOrCreate(['name' => 'user',        'guard_name' => 'web']);

        // تخصیص permission ها

        // سوپر ادمین همه دسترسی های admin
        $superAdmin->syncPermissions(
            Permission::where('guard_name', 'admin')->get()
        );

        // ادمین
        $admin->syncPermissions(
            Permission::where('guard_name', 'admin')->whereIn('name', [
                'view posts',
                'create posts',
                'edit all posts',
                'delete posts',
                'publish posts',
                'manage users',
                'assign roles',
            ])->get()
        );

        // ادیتور
        $editor->syncPermissions(
            Permission::where('guard_name', 'web')->whereIn('name', [
                'view posts',
                'create posts',
                'edit own posts',
                'publish posts',
            ])->get()
        );

        // نویسنده
        $author->syncPermissions(
            Permission::where('guard_name', 'web')->whereIn('name', [
                'view posts',
                'create posts',
                'edit own posts',
            ])->get()
        );

        // کاربر عادی
        $user->syncPermissions(
            Permission::where('guard_name', 'web')->where('name', 'view posts')->get()
        );
    }
}
