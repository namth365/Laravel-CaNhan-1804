<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use WithoutMiddleware;

    public function getEditUserRoute($id)
    {
        return route('users.update', $id);
    }
    public function getRedirectUserRoute()
    {
        return route('users.index');
    }

    /** @test */
    public function user_can_update_user_if_user_login_and_data_valid_and_role_manage()
    {
        $this->login(["manage"]);
        $user = User::factory()->create();
        $dataUserUpdate = User::factory()->make()->toArray();
        $response = $this->put($this->getEditUserRoute($user->id), $dataUserUpdate);
        $userCheck = User::find($user->id);
        $this->assertSame($userCheck->name, $dataUserUpdate['name']);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect($this->getRedirectUserRoute());
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $dataUserUpdate['name'],
        ]);
    }

    /** @test */
    public function user_can_update_user_if_user_login_and_data_valid_and_role_super_admin()
    {
        $this->login(["super-admin"]);
        $user = User::factory()->create();
        $dataUserUpdate = User::factory()->make(['role'=> 2])->toArray();
        $response = $this->put($this->getEditUserRoute($user->id), $dataUserUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect($this->getRedirectUserRoute());
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $dataUserUpdate['name'],
        ]);
    }

    /** @test */
    public function authenticate_can_not_edit_user_if_name_is_null()
    {
        $this->login(["manage"]);
        $user = User::factory()->create();
        $data = User::factory()->make(['name'=> null])->toArray();
        $response = $this->put($this->getEditUserRoute($user->id), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }
    /** @test */
    public function authenticate_can_not_edit_user_if_password_is_null()
    {
        $this->login(["manage"]);
        $user = User::factory()->create();
        $data = User::factory()->make(['password'=> null, 'changePassword' => 'on'])->toArray();
        $response = $this->put($this->getEditUserRoute($user->id), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function authenticate_can_not_edit_user_password_confirmation_if__is_null()
    {
        $this->login(["manage"]);
        $user = User::factory()->create();
        $data = User::factory()->make(['password_confirmation'=> null,'changePassword' => 'on'])->toArray();
        $response = $this->put($this->getEditUserRoute($user->id), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['password_confirmation']);
    }
}
