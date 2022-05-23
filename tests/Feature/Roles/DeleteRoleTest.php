<?php

namespace Tests\Feature\Roles;

use App\Models\Role;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteRoleTest extends TestCase
{
    use WithoutMiddleware;
    public function getDeleteRoleRoute($id)
    {
        return route('roles.destroy', $id);
    }
    public function getRedirectRoleRoute()
    {
        return route('roles.index');
    }

    /** @test*/
    public function authenticate_can_delete_role()
    {
        $this->login(["mange"]);
        $role = Role::factory()->create();
        $roleBefore = Role::count();
        $response = $this->delete($this->getDeleteRoleRoute($role->id));
        $roleAfter = Role::count();
        $this->assertEquals($roleBefore - 1, $roleAfter);
        $this->assertDatabaseMissing('roles', $role->toArray());
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect($this->getRedirectRoleRoute());
    }
    /** @test*/
    public function authenticate_can_not_delete_role()
    {
        $idRole = -1;
        $response = $this->delete($this->getDeleteRoleRoute($idRole));
        $response->assertStatus(Response::HTTP_FOUND);
    }
}
