<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use WithoutMiddleware;

    public function getStoreUserRoute()
    {
        return route('users.store');
    }
    public function getDataValid($dataUsers = [])
    {
        $dataUsersFake = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
        return array_merge($dataUsersFake, $dataUsers);
    }

  /** @test */
    public function user_can_store_user_if_user_login_and_data_valid_and_user_role_manage()
    {
        $this->login(["manage"]);
        $dataUserBefore = User::count();
        $dataUser = $this->getDataValid();
        $response = $this->post($this->getStoreUserRoute(), $dataUser);
        $dataUserAfter = User::count();
        $this->assertEquals($dataUserBefore + 1, $dataUserAfter);
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('users', [
          'name' => $dataUser['name'],
          'email' => $dataUser['email']
        ]);
        $response->assertRedirect(route('users.index'));
    }

  /** @test */

    public function user_can_not_store_user_if_name_is_null()
    {
        $this->login(["manage"]);
        $dataUser = User::factory()->make(['name'=>null])->toArray();
        $response = $this->post($this->getStoreUserRoute(), $dataUser);
        $response->assertSessionHasErrors(['name']);
    }

  /** @test */

    public function user_can_not_store_user_if_email_is_null()
    {
        $this->login(["manage"]);
        $dataUser = User::factory()->make(['email'=> null])->toArray();
        $response = $this->post($this->getStoreUserRoute(), $dataUser);
        $response->assertSessionHasErrors(['email']);
    }
  /** @test */

    public function authenticate_can_not_store_user_if_password_is_null()
    {
        $this->login(["manage"]);
        $dataUser = User::factory()->make(['password'=> null])->toArray();
        $response = $this->post($this->getStoreUserRoute(), $dataUser);
        $response->assertSessionHasErrors(['password']);
    }

  /** @test */

    public function authenticate_can_not_store_user_if_data_is_null()
    {
        $this->login(["manage"]);
        $dataUser = User::factory()->make(['name' => null, 'password' => null])->toArray();
        $response = $this->post($this->getStoreUserRoute(), $dataUser);
        $response->assertSessionHasErrors(['name', 'password', 'password']);
    }
}
