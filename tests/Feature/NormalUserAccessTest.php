<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Contracts\Role;
use Tests\TestCase;

class NormalUserAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        $this->app[Role::class]->create(['name' => 'NormalUser']);
//        $this->app[Permission::class]->create(['name' => 'edit-articles']);
    }

    /** @test */
    public function user_must_login_to_access_dashboard()
    {
        $this->get(route('dashboard'))
            ->assertRedirect('login');
    }

    /** @test */
    public function users_cannot_access_to_admin_dashboard()
    {
        //Having
        $user = factory(User::class)->create();
        $user->assignRole('NormalUser');
        $this->actingAs($user);

        //When
        $response = $this->get(route('admin.dashboard'));

        //Then
        $response->assertForbidden();
    }

    /** @test */
    public function user_can_access_to_home()
    {
        //Having
        $user = factory(User::class)->create();
        $user->assignRole('NormalUser');
        $this->actingAs($user);

        //When
        $response = $this->get(route('home'));

        //Then
        $response->assertOk();
    }
}
