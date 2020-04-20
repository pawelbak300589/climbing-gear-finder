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
            'SuperAdmin',
            'Admin',
            'NormalUser',
            'PremiumUser',
        ];

        foreach ($roles as $role)
        {
            Role::create(['name' => $role]);
        }
    }
}
