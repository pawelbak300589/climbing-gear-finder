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
                'List roles',
                'Create roles',
                'Update roles',
                'Delete roles',
                'List permissions',
                'Create permissions',
                'Update permissions',
                'Delete permissions',
                'List users',
                'Create users',
                'Update users',
                'Delete users',
                'List brands',
                'Create brands',
                'Update brands',
                'Delete brands',
                'List gear',
                'Create gear',
                'Update gear',
                'Delete gear'
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
