<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use WithoutMiddleware;
    public function getDeleteUserRoute($id)
    {
        return route('users.destroy', $id);
    }
    public function getRedirectUserRoute()
    {
        return route('users.index');
    }

    /** @test */
    public function authenticate_can_delete_user()
    {
        $this->login(["manage"]);
        $user = User::factory()->create();
        $userBefore = User::count();
        $response = $this->delete($this->getDeleteUserRoute($user->id));
        $userAfter = User::count();
        $this->assertEquals($userBefore - 1, $userAfter);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => $user->name,
            'password' => $user->password,
        ]);
        $response->assertRedirect($this->getRedirectUserRoute());
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /** @test */
    public function authenticate_can_not_delete_user()
    {
        $deleteId = -1;
        $response = $this->delete($this->getDeleteUserRoute($deleteId));
        $response->assertStatus(Response::HTTP_FOUND);
    }
}
