<?php

namespace Tests\Feature\Admin;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Tests\TestCase;

class PermissionsPageAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // Create Permissions
        $this->app[Permission::class]->create(['name' => 'permission-list']);
        $this->app[Permission::class]->create(['name' => 'permission-create']);
        $this->app[Permission::class]->create(['name' => 'permission-edit']);
        $this->app[Permission::class]->create(['name' => 'permission-delete']);

        // Create Roles
        $this->app[Role::class]->create(['name' => 'SuperAdmin']);
        $adminRole = $this->app[Role::class]->create(['name' => 'Admin']);
        $this->app[Role::class]->create(['name' => 'NormalUser']);
        $this->app[Role::class]->create(['name' => 'PremiumUser']);

        // Assign permissions to roles
        $adminRole->syncPermissions(['permission-list', 'permission-create', 'permission-edit', 'permission-delete']);
    }

    /** @test */
    public function guests_cannot_manage_roles()
    {
        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'NewPermission1']);

        $this->get('/admin/permissions')->assertRedirect('login');
        $this->get('/admin/permissions/create')->assertRedirect('login');
        $this->get('/admin/permissions/' . $permission->id)->assertRedirect('login');
        $this->get('/admin/permissions/' . $permission->id . '/edit')->assertRedirect('login');
        $this->post('/admin/permissions', ['name' => 'NewPermission2', 'roles' => [1, 2, 3, 4]])
            ->assertRedirect('login');
        $this->patch('/admin/permissions/' . $permission->id, ['name' => 'UpdatedNewPermission1', 'roles' => [2, 3]])
            ->assertRedirect('login');
    }

    /** @test */
    public function normal_user_cannot_manage_roles()
    {
        $normalUser = factory(User::class)->create();
        $normalUser->assignRole('NormalUser');
        $this->actingAs($normalUser);

        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'NewPermission1']);

        $this->get('/admin/permissions')->assertForbidden();
        $this->get('/admin/permissions/create')->assertForbidden();
        $this->get('/admin/permissions/' . $permission->id)->assertForbidden();
        $this->get('/admin/permissions/' . $permission->id . '/edit')->assertForbidden();
        $this->post('/admin/permissions', ['name' => 'NewPermission2', 'roles' => [1, 2, 3, 4]])
            ->assertForbidden();
        $this->patch('/admin/permissions/' . $permission->id, ['name' => 'UpdatedNewPermission1', 'roles' => [2, 3]])
            ->assertForbidden();
    }

    /** @test */
    public function premium_user_cannot_manage_roles()
    {
        $normalUser = factory(User::class)->create();
        $normalUser->assignRole('PremiumUser');
        $this->actingAs($normalUser);

        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'NewPermission1']);

        $this->get('/admin/permissions')->assertForbidden();
        $this->get('/admin/permissions/create')->assertForbidden();
        $this->get('/admin/permissions/' . $permission->id)->assertForbidden();
        $this->get('/admin/permissions/' . $permission->id . '/edit')->assertForbidden();
        $this->post('/admin/permissions', ['name' => 'NewPermission2', 'roles' => [1, 2, 3, 4]])
            ->assertForbidden();
        $this->patch('/admin/permissions/' . $permission->id, ['name' => 'UpdatedNewPermission1', 'roles' => [2, 3]])
            ->assertForbidden();
    }

    /** @test */
    public function admin_can_manage_roles()
    {
        $this->withoutExceptionHandling();

        $adminUser = factory(User::class)->create();
        $adminUser->assignRole('Admin');
        $this->actingAs($adminUser);

        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'NewPermission1']);

        $this->get('/admin/permissions')->assertOk();
        $this->get('/admin/permissions/create')->assertOk();
        $this->get('/admin/permissions/' . $permission->id)->assertOk();
        $this->get('/admin/permissions/' . $permission->id . '/edit')->assertOk();
        $this->post('/admin/permissions', ['name' => 'NewPermission2', 'roles' => [1, 2, 3, 4]])
            ->assertRedirect('/admin/permissions');
        $this->patch('/admin/permissions/' . $permission->id, ['name' => 'UpdatedNewPermission1', 'roles' => [2, 3]])
            ->assertRedirect('/admin/permissions');
    }

    /** @test */
    public function superadmin_can_manage_roles()
    {
        $this->withoutExceptionHandling();

        $superAdminUser = factory(User::class)->create();
        $superAdminUser->assignRole('SuperAdmin');
        $this->actingAs($superAdminUser);

        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'NewPermission1']);

        $this->get('/admin/permissions')->assertOk();
        $this->get('/admin/permissions/create')->assertOk();
        $this->get('/admin/permissions/' . $permission->id)->assertOk();
        $this->get('/admin/permissions/' . $permission->id . '/edit')->assertOk();
        $this->post('/admin/permissions', ['name' => 'NewPermission2', 'roles' => [1, 2, 3, 4]])
            ->assertRedirect('/admin/permissions');
        $this->patch('/admin/permissions/' . $permission->id, ['name' => 'UpdatedNewPermission1', 'roles' => [2, 3]])
            ->assertRedirect('/admin/permissions');
    }
}
