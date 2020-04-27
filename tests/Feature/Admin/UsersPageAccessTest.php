<?php

namespace Tests\Feature\Admin;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Tests\TestCase;

class UsersPageAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // Create Permissions
        $this->app[Permission::class]->create(['name' => 'user-list']);
        $this->app[Permission::class]->create(['name' => 'user-create']);
        $this->app[Permission::class]->create(['name' => 'user-edit']);
        $this->app[Permission::class]->create(['name' => 'user-delete']);

        // Create Roles
        $this->app[Role::class]->create(['name' => 'SuperAdmin']);
        $adminRole = $this->app[Role::class]->create(['name' => 'Admin']);
        $this->app[Role::class]->create(['name' => 'NormalUser']);
        $this->app[Role::class]->create(['name' => 'PremiumUser']);

        // Assign permissions to roles
        $adminRole->syncPermissions(['user-list', 'user-create', 'user-edit', 'user-delete']);
    }

    /** @test */
    public function guests_cannot_manage_users()
    {
        $user = factory(User::class)->create();

        $this->get('/admin/users')->assertRedirect('login');
        $this->get('/admin/users/create')->assertRedirect('login');
        $this->get($user->adminPath())->assertRedirect('login');
        $this->get($user->adminPath() . '/edit')->assertRedirect('login');
        $this->post('/admin/users', ['name' => 'NewUser', 'email' => 'newuser@test.com', 'role' => 'NormalUser'])
            ->assertRedirect('login');
        $this->patch($user->adminPath(), ['name' => 'UpdatedNewUser', 'email' => 'updatednewuser@test.com', 'role' => 'PremiumUser'])
            ->assertRedirect('login');
    }

    /** @test */
    public function normal_user_cannot_manage_users()
    {
        $normalUser = factory(User::class)->create();
        $normalUser->assignRole('NormalUser');
        $this->actingAs($normalUser);

        $user = factory(User::class)->create();

        $this->get('/admin/users')->assertForbidden();
        $this->get('/admin/users/create')->assertForbidden();
        $this->get($user->adminPath())->assertForbidden();
        $this->get($user->adminPath() . '/edit')->assertForbidden();
        $this->post('/admin/users', ['name' => 'NewUser', 'email' => 'newuser@test.com', 'role' => 'NormalUser'])
            ->assertForbidden();
        $this->patch($user->adminPath(), ['name' => 'UpdatedNewUser', 'email' => 'updatednewuser@test.com', 'role' => 'PremiumUser'])
            ->assertForbidden();
    }

    /** @test */
    public function premium_user_cannot_manage_users()
    {
        $normalUser = factory(User::class)->create();
        $normalUser->assignRole('PremiumUser');
        $this->actingAs($normalUser);

        $user = factory(User::class)->create();

        $this->get('/admin/users')->assertForbidden();
        $this->get('/admin/users/create')->assertForbidden();
        $this->get($user->adminPath())->assertForbidden();
        $this->get($user->adminPath() . '/edit')->assertForbidden();
        $this->post('/admin/users', ['name' => 'NewUser', 'email' => 'newuser@test.com', 'role' => 'NormalUser'])
            ->assertForbidden();
        $this->patch($user->adminPath(), ['name' => 'UpdatedNewUser', 'email' => 'updatednewuser@test.com', 'role' => 'PremiumUser'])
            ->assertForbidden();
    }

    /** @test */
    public function admin_can_access_users_list_page()
    {
        $this->withoutExceptionHandling();

        $adminUser = factory(User::class)->create();
        $adminUser->assignRole('Admin');
        $this->actingAs($adminUser);

        $user = factory(User::class)->create();

        $this->get('/admin/users')->assertOk();
        $this->get('/admin/users/create')->assertOk();
        $this->get($user->adminPath())->assertOk();
        $this->get($user->adminPath() . '/edit')->assertOk();
        $this->post('/admin/users', ['name' => 'NewUser', 'email' => 'newuser@test.com', 'role' => 'NormalUser'])
            ->assertRedirect('/admin/users');
        $this->patch($user->adminPath(), ['name' => 'UpdatedNewUser', 'email' => 'updatednewuser@test.com', 'role' => 'PremiumUser'])
            ->assertRedirect('/admin/users');
    }

    /** @test */
    public function superadmin_can_manage_users()
    {
        $this->withoutExceptionHandling();

        $superAdminUser = factory(User::class)->create();
        $superAdminUser->assignRole('SuperAdmin');
        $this->actingAs($superAdminUser);

        $user = factory(User::class)->create();

        $this->get('/admin/users')->assertOk();
        $this->get('/admin/users/create')->assertOk();
        $this->get($user->adminPath())->assertOk();
        $this->get($user->adminPath() . '/edit')->assertOk();
        $this->post('/admin/users', ['name' => 'NewUser', 'email' => 'newuser@test.com', 'role' => 'NormalUser'])
            ->assertRedirect('/admin/users');
        $this->patch($user->adminPath(), ['name' => 'UpdatedNewUser', 'email' => 'updatednewuser@test.com', 'role' => 'PremiumUser'])
            ->assertRedirect('/admin/users');
    }
}
