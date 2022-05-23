<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class ListUserTest extends TestCase
{

    public function getListUserRoute()
    {
        return route('users.index');
    }

    /** @test */
    public function authenticate_can_get_list_user()
    {
        $this->login(["manage"]);
        $user = User::factory()->create();
        $response = $this->get($this->getListUserRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.index');
    }

    /** @test */
    public function unAuthenticate_can_list_user()
    {
        $response = $this->get($this->getListUserRoute());
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticate_can_user_list_search()
    {
        $this->login(["manage"]);
        $user = $this->getDataValid(['name'=>'admin']);
        $response = $this->get($this->getListUserRoute(), $user);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('users', ['name' => $user['name']]);
        $response->assertSee(['name']);
        $response->assertViewIs('users.index');
    }

    /** @test */
    public function authenticate_can_not_user_list_search()
    {
        $this->login(["manage"]);
        $user = $this->getDataValid();
        $response = $this->get($this->getListUserRoute(), $user);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('users', ['name' => $user['name']]);
        $response->assertSee(['name']);

        $response->assertViewIs('users.index');
    }

    public function getDataValid($dataSearchUsers = [])
    {
        $dataSearchUsersFake = [
            'name' => $this->faker->name,
            'email' => '',
            'role_name'=>''
        ];
        return array_merge($dataSearchUsersFake, $dataSearchUsers);
    }
}
