<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Contracts\Role;
use Tests\TestCase;

class UsersPageAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        $this->app[Role::class]->create(['name' => 'SuperAdmin']);
        $this->app[Role::class]->create(['name' => 'Admin']);
//        $this->app[Permission::class]->create(['name' => 'edit-articles']);
    }

    /** @test */
    public function superadmin_can_access_users_list_page()
    {
        $this->withoutExceptionHandling();
        //Having
        $superAdminUser = factory(User::class)->create();
        $superAdminUser->assignRole('SuperAdmin');
        $this->actingAs($superAdminUser);

        //When
        $response = $this->get(route('admin.users.index'));

        //Then
        $response->assertOk();
    }

    /** @test */
    public function admin_can_access_users_list_page()
    {
        $this->withoutExceptionHandling();
        //Having
        $adminUser = factory(User::class)->create();
        $adminUser->assignRole('Admin');
        $this->actingAs($adminUser);

        //When
        $response = $this->get(route('admin.users.index'));

        //Then
        $response->assertOk();
    }

    /** @test */
    public function superadmin_can_access_users_create_page()
    {
        $this->withoutExceptionHandling();
        //Having
        $superAdminUser = factory(User::class)->create();
        $superAdminUser->assignRole('SuperAdmin');
        $this->actingAs($superAdminUser);

        //When
        $response = $this->get(route('admin.users.create'));

        //Then
        $response->assertOk();
    }

    /** @test */
    public function admin_can_access_users_create_page()
    {
        $this->withoutExceptionHandling();
        //Having
        $adminUser = factory(User::class)->create();
        $adminUser->assignRole('Admin');
        $this->actingAs($adminUser);

        //When
        $response = $this->get(route('admin.users.create'));

        //Then
        $response->assertOk();
    }
}
