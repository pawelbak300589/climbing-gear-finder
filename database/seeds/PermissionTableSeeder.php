<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
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

        $permissions = [
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
        ];

        foreach ($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }
    }
}
