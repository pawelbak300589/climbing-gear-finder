<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $roles = [
            'SuperAdmin' => [
                // has granted all permissions in AuthServiceProvider line 31-33
            ],
            'Admin' => [
                'role-list',
                'role-create',
                'role-edit',
                'role-delete',
                'permission-list',
                'permission-create',
                'permission-edit',
                'permission-delete',
                'user-list',
                'user-create',
                'user-edit',
                'user-delete',
                'brand-list',
                'brand-create',
                'brand-edit',
                'brand-delete',
                'gear-list',
                'gear-create',
                'gear-edit',
                'gear-delete'
            ],
            'NormalUser' => [],
            'PremiumUser' => [],
        ];

        foreach ($roles as $roleName => $permissions)
        {
            $role = Role::create(['name' => $roleName]);
            foreach ($permissions as $permission)
            {
                $role->givePermissionTo($permission);
            }
        }
    }
}
