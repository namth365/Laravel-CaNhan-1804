<?php

namespace Tests\Feature\Categories;

use Illuminate\Http\Response;
use Tests\TestCase;

class ListCategoryTest extends TestCase
{
    public function getListCategoryRoute()
    {
        return route('categories.index');
    }

    /** @test */
    public function authenticate_can_get_list_category()
    {
        $this->login(["manage"]);
        $response = $this->get($this->getListCategoryRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('categories.index');
    }

    /** @test */
    public function unauthenticated_can_get_list_category()
    {
        $response = $this->get($this->getListCategoryRoute());
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticate_can_category_list_search()
    {
        $this->login(["manage"]);
        $user = ['name'=>'ao'];
        $response = $this->get($this->getListCategoryRoute(), $user);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('categories', ['name' => $user['name']]);
        $response->assertSee(['name']);
        $response->assertViewIs('categories.index');
    }

    /** @test */
    public function authenticate_can_not_category_list_search()
    {
        $this->login(["manage"]);
        $category = ['name'=>$this->faker->name];
        $response = $this->get($this->getListCategoryRoute(), $category);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('users', ['name' => $category['name']]);
        $response->assertSee(['name']);

        $response->assertViewIs('categories.index');
    }
}
