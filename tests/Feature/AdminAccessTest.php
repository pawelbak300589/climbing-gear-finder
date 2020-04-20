<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Contracts\Permission;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        $this->app[Role::class]->create(['name' => 'SuperAdmin']);
        $this->app[Role::class]->create(['name' => 'Admin']);
//        $this->app[Permission::class]->create(['name' => 'edit-articles']);
    }

    /** @test */
    public function user_must_login_to_access_admin_dashboard()
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect('login');
    }

    /** @test */
    public function superadmin_can_access_to_admin_dashboard()
    {
        //Having
        $superAdminUser = factory(User::class)->create();
        $superAdminUser->assignRole('SuperAdmin');
        $this->actingAs($superAdminUser);

        //When
        $response = $this->get(route('admin.dashboard'));

        //Then
        $response->assertOk();
    }

    /** @test */
    public function admin_can_access_to_admin_dashboard()
    {
        //Having
        $adminUser = factory(User::class)->create();
        $adminUser->assignRole('Admin');
        $this->actingAs($adminUser);

        //When
        $response = $this->get(route('admin.dashboard'));

        //Then
        $response->assertOk();
    }

    /** @test */
    public function superadmin_can_access_to_home()
    {
        //Having
        $superAdminUser = factory(User::class)->create();
        $superAdminUser->assignRole('SuperAdmin');
        $this->actingAs($superAdminUser);

        //When
        $response = $this->get(route('home'));

        //Then
        $response->assertOk();
    }

    /** @test */
    public function admin_can_access_to_home()
    {
        //Having
        $adminUser = factory(User::class)->create();
        $adminUser->assignRole('Admin');
        $this->actingAs($adminUser);

        //When
        $response = $this->get(route('home'));

        //Then
        $response->assertOk();
    }
}
