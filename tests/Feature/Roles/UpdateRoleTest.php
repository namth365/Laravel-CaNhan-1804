<?php

namespace Tests\Feature\Roles;

use App\Models\Role;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    use WithoutMiddleware;

    public function getUpdateRoleRoute($id)
    {
        return route('roles.update', $id);
    }

    public function getRedirectRoleRoute()
    {
        return route('roles.index');
    }
    /** @test */

    public function authenticate_can_update_role()
    {
        $this->login(["manage"]);
        $role = Role::factory()->create();
        $dataUpdate = Role::factory()->make(['permission' => array(1,2)])->toArray();
        $response = $this->put($this->getUpdateRoleRoute($role->id), $dataUpdate);
        $roleCheck = Role::find($role->id);
        $this->assertSame($roleCheck->name, $dataUpdate['name']);
        $this->assertDatabaseHas('roles', [
            'name' => $dataUpdate['name'],
        ]);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect($this->getRedirectRoleRoute());
    }
    /** @test */

    public function authenticate_can_not_update_role_if_name_is_null()
    {
        $role = Role::factory()->create();

        $dataUpdate = Role::factory()->make(['name' => null, 'permission' => array(1,2)])->toArray();
        $response = $this->put($this->getUpdateRoleRoute($role->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }
    /** @test */
    public function authenticate_can_not_update_role_if_permissison_is_null()
    {
        $role = Role::factory()->create();
        $dataUpdate = Role::factory()->make(['permission' => null])->toArray();
        $response = $this->put($this->getUpdateRoleRoute($role->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['permission']);
    }
}
