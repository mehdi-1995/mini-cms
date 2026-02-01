<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $Permissions = [
            'view posts',
            'create posts',
            'edit own posts',
            'edit all posts',
            'delete posts',
            'publish posts',
            'manage users',
            'assign roles',
        ];

        foreach ($Permissions as $Permission) {
            Permission::FirstOrCreate(['name' => $Permission ]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $editor     = Role::firstOrCreate(['name' => 'editor']);
        $author     = Role::firstOrCreate(['name' => 'author']);
        $user       = Role::firstOrCreate(['name' => 'user']);

        $superAdmin->givePermissionTo(Permission::all());
        
        $admin->givePermissionTo([
            'view posts',
            'create posts',
            'edit all posts',
            'delete posts',
            'publish posts',
            'manage users',
            'assign roles',
        ]);

        $editor->givePermissionTo([
            'view posts',
            'create posts',
            'edit own posts',
            'publish posts',
        ]);

        $author->givePermissionTo([
            'view posts',
            'create posts',
            'edit own posts',
        ]);

        $user->givePermissionTo([
            'view posts',
        ]);

    }
}
