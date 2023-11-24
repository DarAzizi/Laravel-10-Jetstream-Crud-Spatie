<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list books']);
        Permission::create(['name' => 'view books']);
        Permission::create(['name' => 'create books']);
        Permission::create(['name' => 'update books']);
        Permission::create(['name' => 'delete books']);

        Permission::create(['name' => 'list certificates']);
        Permission::create(['name' => 'view certificates']);
        Permission::create(['name' => 'create certificates']);
        Permission::create(['name' => 'update certificates']);
        Permission::create(['name' => 'delete certificates']);

        Permission::create(['name' => 'list cities']);
        Permission::create(['name' => 'view cities']);
        Permission::create(['name' => 'create cities']);
        Permission::create(['name' => 'update cities']);
        Permission::create(['name' => 'delete cities']);

        Permission::create(['name' => 'list countries']);
        Permission::create(['name' => 'view countries']);
        Permission::create(['name' => 'create countries']);
        Permission::create(['name' => 'update countries']);
        Permission::create(['name' => 'delete countries']);

        Permission::create(['name' => 'list graduations']);
        Permission::create(['name' => 'view graduations']);
        Permission::create(['name' => 'create graduations']);
        Permission::create(['name' => 'update graduations']);
        Permission::create(['name' => 'delete graduations']);

        Permission::create(['name' => 'list remarks']);
        Permission::create(['name' => 'view remarks']);
        Permission::create(['name' => 'create remarks']);
        Permission::create(['name' => 'update remarks']);
        Permission::create(['name' => 'delete remarks']);

        Permission::create(['name' => 'list results']);
        Permission::create(['name' => 'view results']);
        Permission::create(['name' => 'create results']);
        Permission::create(['name' => 'update results']);
        Permission::create(['name' => 'delete results']);

        Permission::create(['name' => 'list universities']);
        Permission::create(['name' => 'view universities']);
        Permission::create(['name' => 'create universities']);
        Permission::create(['name' => 'update universities']);
        Permission::create(['name' => 'delete universities']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
