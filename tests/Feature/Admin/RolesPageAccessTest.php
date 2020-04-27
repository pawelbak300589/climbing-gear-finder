<?php

namespace Tests\Feature\Admin;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Tests\TestCase;

class RolesPageAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // Create Permissions
        $this->app[Permission::class]->create(['name' => 'role-list']);
        $this->app[Permission::class]->create(['name' => 'role-create']);
        $this->app[Permission::class]->create(['name' => 'role-edit']);
        $this->app[Permission::class]->create(['name' => 'role-delete']);

        // Create Roles
        $this->app[Role::class]->create(['name' => 'SuperAdmin']);
        $adminRole = $this->app[Role::class]->create(['name' => 'Admin']);
        $this->app[Role::class]->create(['name' => 'NormalUser']);
        $this->app[Role::class]->create(['name' => 'PremiumUser']);

        // Assign permissions to roles
        $adminRole->syncPermissions(['role-list', 'role-create', 'role-edit', 'role-delete']);
    }

    /** @test */
    public function guests_cannot_manage_roles()
    {
        $role = \Spatie\Permission\Models\Role::create(['name' => 'NewRole1']);

        $this->get('/admin/roles')->assertRedirect('login');
        $this->get('/admin/roles/create')->assertRedirect('login');
        $this->get('/admin/roles/' . $role->id)->assertRedirect('login');
        $this->get('/admin/roles/' . $role->id . '/edit')->assertRedirect('login');
        $this->post('/admin/roles', ['name' => 'NewRole2', 'permissions' => [1, 2, 3, 4]])
            ->assertRedirect('login');
        $this->patch('/admin/roles/' . $role->id, ['name' => 'UpdatedNewRole1', 'permissions' => [2, 3]])
            ->assertRedirect('login');
    }

    /** @test */
    public function normal_user_cannot_manage_roles()
    {
        $normalUser = factory(User::class)->create();
        $normalUser->assignRole('NormalUser');
        $this->actingAs($normalUser);

        $role = \Spatie\Permission\Models\Role::create(['name' => 'NewRole1']);

        $this->get('/admin/roles')->assertForbidden();
        $this->get('/admin/roles/create')->assertForbidden();
        $this->get('/admin/roles/' . $role->id)->assertForbidden();
        $this->get('/admin/roles/' . $role->id . '/edit')->assertForbidden();
        $this->post('/admin/roles', ['name' => 'NewRole2', 'permissions' => [1, 2, 3, 4]])
            ->assertForbidden();
        $this->patch('/admin/roles/' . $role->id, ['name' => 'UpdatedNewRole1', 'permissions' => [2, 3]])
            ->assertForbidden();
    }

    /** @test */
    public function premium_user_cannot_manage_roles()
    {
        $normalUser = factory(User::class)->create();
        $normalUser->assignRole('PremiumUser');
        $this->actingAs($normalUser);

        $role = \Spatie\Permission\Models\Role::create(['name' => 'NewRole1']);

        $this->get('/admin/roles')->assertForbidden();
        $this->get('/admin/roles/create')->assertForbidden();
        $this->get('/admin/roles/' . $role->id)->assertForbidden();
        $this->get('/admin/roles/' . $role->id . '/edit')->assertForbidden();
        $this->post('/admin/roles', ['name' => 'NewRole2', 'permissions' => [1, 2, 3, 4]])
            ->assertForbidden();
        $this->patch('/admin/roles/' . $role->id, ['name' => 'UpdatedNewRole1', 'permissions' => [2, 3]])
            ->assertForbidden();
    }

    /** @test */
    public function admin_can_manage_roles()
    {
        $this->withoutExceptionHandling();

        $adminUser = factory(User::class)->create();
        $adminUser->assignRole('Admin');
        $this->actingAs($adminUser);

        $role = \Spatie\Permission\Models\Role::create(['name' => 'NewRole1']);

        $this->get('/admin/roles')->assertOk();
        $this->get('/admin/roles/create')->assertOk();
        $this->get('/admin/roles/' . $role->id)->assertOk();
        $this->get('/admin/roles/' . $role->id . '/edit')->assertOk();
        $this->post('/admin/roles', ['name' => 'NewRole2', 'permissions' => [1, 2, 3, 4]])
            ->assertRedirect('/admin/roles');
        $this->patch('/admin/roles/' . $role->id, ['name' => 'UpdatedNewRole1', 'permissions' => [2, 3]])
            ->assertRedirect('/admin/roles');
    }

    /** @test */
    public function superadmin_can_manage_roles()
    {
        $this->withoutExceptionHandling();

        $superAdminUser = factory(User::class)->create();
        $superAdminUser->assignRole('SuperAdmin');
        $this->actingAs($superAdminUser);

        $role = \Spatie\Permission\Models\Role::create(['name' => 'NewRole1']);

        $this->get('/admin/roles')->assertOk();
        $this->get('/admin/roles/create')->assertOk();
        $this->get('/admin/roles/' . $role->id)->assertOk();
        $this->get('/admin/roles/' . $role->id . '/edit')->assertOk();
        $this->post('/admin/roles', ['name' => 'NewRole2', 'permissions' => [1, 2, 3, 4]])
            ->assertRedirect('/admin/roles');
        $this->patch('/admin/roles/' . $role->id, ['name' => 'UpdatedNewRole1', 'permissions' => [2, 3]])
            ->assertRedirect('/admin/roles');
    }
}
