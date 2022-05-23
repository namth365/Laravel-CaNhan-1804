<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use WithoutMiddleware;
    public function getStoreCategoryRoute()
    {
        return route('categories.store');
    }
    public function getRedirectCategoryRoute()
    {
        return route('categories.index');
    }

    /** @test */
    public function authenticate_can_store_category()
    {
        $this->login(["manage"]);
        $dataCreate = Category::factory()->make()->toArray();
        $categoryBefore = Category::count();
        $response = $this->post($this->getStoreCategoryRoute(), $dataCreate);
        $categoryAfter = Category::count();
        $this->assertEquals($categoryBefore + 1, $categoryAfter);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect($this->getRedirectCategoryRoute());
    }
    /** @test */
    public function authenticate_can_not_store_category_if_name_is_null()
    {
        $this->login(["manage"]);
        $dataCreate = Category::factory()->make(['name'=>''])->toArray();
        $response = $this->post($this->getStoreCategoryRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }
}
