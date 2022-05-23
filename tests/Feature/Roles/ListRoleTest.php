<?php

namespace Tests\Feature\Roles;

use App\Models\Role;
use Illuminate\Http\Response;
use Tests\TestCase;

class ListRoleTest extends TestCase
{
    public function getListRoleRoute()
    {
        return route('roles.index');
    }

    /** @test */

    public function authenticate_can_get_list_role()
    {
        $this->login(["manage"]);
        $role = Role::factory()->create();
        $response = $this->get($this->getListRoleRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('roles.index');
    }

    /** @test */

    public function unauthenticated_can_not_get_list_role()
    {
        $response = $this->get($this->getListRoleRoute());
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }

    /** @test */

    public function authenticate_can_role_list_search()
    {
        $this->login(["manage"]);
        $role = Role::factory()->make(['name'=>'manage'])->toArray();
        $response = $this->get($this->getListRoleRoute(), $role);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('roles', ['name' => $role['name']]);
        $response->assertSee(['name']);
        $response->assertViewIs('roles.index');
    }

    /** @test */
    public function authenticate_can_not_role_list_search()
    {
        $this->login(["manage"]);
        $role = Role::factory()->make()->toArray();
        $response = $this->get($this->getListRoleRoute(), $role);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('roles', ['name' => $role['name']]);
        $response->assertSee(['name']);

        $response->assertViewIs('roles.index');
    }
}
