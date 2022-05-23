<?php

namespace Tests\Feature\Authenticate;

use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function loginRoute()
    {
        return route('login');
    }

    /** @test */
    public function user_can_view_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('auth.login')->assertSee('login');
    }

    /** @test */
    public function user_can_login()
    {
        $dataLogin = $this->getDataValid(['email'=>'levantuanpxu@gmail.com', 'password' =>'$2y$10$hbAP8cranIHEzorIrvblguuwfFqVz80KBLocjhiOxBH6v/RggN9Te']);
        $response = $this->post($this->loginRoute(), $dataLogin);
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('users', ['email' => $dataLogin['email'], 'password' => $dataLogin['password']]);
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_can_not_login()
    {
        $dataLogin = $this->getDataValid();
        $response = $this->post($this->loginRoute(), $dataLogin);
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseMissing('users', ['email' => $dataLogin['email'], 'password' => $dataLogin['password']]);
    }

    /** @test */
    public function user_can_not_login_if_email_is_null()
    {
        $dataLogin = $this->getDataValid(['email'=>'']);
        $response = $this->post($this->loginRoute(), $dataLogin);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_can_not_login_if_password_is_null()
    {
        $dataLogin = $this->getDataValid(['password'=>'']);
        $response = $this->post($this->loginRoute(), $dataLogin);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['password']);
    }

    public function getDataValid($dataLogin = [])
    {
        $dataLoginUsersFake = [
            'email' => $this->faker->unique()->safeEmail(),
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
        return array_merge($dataLoginUsersFake, $dataLogin);
    }
}
