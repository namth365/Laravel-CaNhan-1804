<?php

namespace Tests\Feature\Authenticate;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    public function storeRegisterRoute()
    {
        return route('register');
    }

    /** @test */
    public function user_can_view_register()
    {
        $response = $this->get('/register');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('auth.register')->assertSee('register');
    }

    /** @test */
    public function user_can_register()
    {
        $dataRegister = User::factory()->make(['password-confirm' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'])->toArray();
        $response = $this->post($this->storeRegisterRoute(), $dataRegister);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_can_not_register_if_name_is_null()
    {
        $dataRegister = User::factory()->make(['name' => null, 'password-confirm' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'])->toArray();
        $response = $this->post($this->storeRegisterRoute(), $dataRegister);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function user_can_not_register_if_email_is_null()
    {
        $dataRegister = User::factory()->make(['email' => null])->toArray();
        $response = $this->post($this->storeRegisterRoute(), $dataRegister);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_can_not_register_if_password_is_null()
    {
        $dataRegister = User::factory()->make([ 'password' => ''])->toArray();
        $response = $this->post($this->storeRegisterRoute(), $dataRegister);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['password']);
    }
}
