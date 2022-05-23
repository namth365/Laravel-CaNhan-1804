<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use WithoutMiddleware;

    public function getUpdateCategoryRoute($id)
    {
        return route('categories.update', $id);
    }

    public function getRedirectCategoryRoute()
    {
        return route('categories.index');
    }

    /** @test */
    public function authenticate_can_update_category()
    {
        $this->login(["manage"]);
        $category = Category::factory()->create();
        $dataUpdate = Category::factory()->make()->toArray();
        $response = $this->put($this->getUpdateCategoryRoute($category->id), $dataUpdate);
        $categoryCheck = Category::find($category->id);
        $this->assertSame($categoryCheck->name, $dataUpdate['name']);
        $this->assertSame($categoryCheck->parent_id, $dataUpdate['parent_id']);
        $response->assertRedirect($this->getRedirectCategoryRoute());
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /** @test */
    public function authenticate_can_not_update_category_if_name_is_null()
    {
        $this->login(["manage"]);
        $category = Category::factory()->create();
        $dataUpdate = Category::factory()->make(['name' => null])->toArray();
        $response = $this->put($this->getUpdateCategoryRoute($category->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }
}
