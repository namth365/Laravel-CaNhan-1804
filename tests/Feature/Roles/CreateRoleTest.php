<?php

namespace Tests\Feature\Roles;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Role;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use WithoutMiddleware;

    public function getCreateRoleRoute()
    {
        return route('roles.store');
    }

    public function getRedirectRoleRoute()
    {
        return route('roles.index');
    }

    /** @test */
    public function authenticate_can_store_role()
    {
        $this->login(["manage"]);
        $dataCreate = Role::factory()->make(['permission' => array(1,2)])->toArray();
        $roleBefore = Role::count();
        $response = $this->post($this->getCreateRoleRoute(), $dataCreate);
        $roleAfter = Role::count();
        $this->assertEquals($roleBefore + 1, $roleAfter);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect($this->getRedirectRoleRoute());
    }

    /** @test */
    public function authenticate_can_not_store_role_if_name_null()
    {
        $this->login(["manage"]);
        $dataCreate = Role::factory()->make([ 'name' => null])->toArray();
        $response = $this->post($this->getCreateRoleRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function authenticate_can_not_store_role_if_permission_null()
    {
        $this->login(["manage"]);
        $dataCreate = Role::factory()->make([ 'permission' => null])->toArray();
        $response = $this->post($this->getCreateRoleRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['permission']);
    }

    /** @test */
    public function authenticate_can_not_store_role_if_data_is_null()
    {
        $this->login(["manage"]);
        $dataCreate = Role::factory()->make(['name' =>null, 'permission' => null])->toArray();
        $response = $this->post($this->getCreateRoleRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name', 'permission']);
    }
}
