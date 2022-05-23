<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use WithoutMiddleware;

    public function getDeleteCategoryRoute($id)
    {
        return route('categories.destroy',$id);
    }

    /** @test */
    public function authenticate_can_delete_category()
    {
        $this->login(["manage"]);
        $category = Category::factory()->create();
        $countCategoryBefore = Category::count();
        $response = $this->delete($this->getDeleteCategoryRoute($category->id));
        $countCategoryAfter = Category::count();
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals($countCategoryBefore - 1, $countCategoryAfter);
        $this->assertDatabaseMissing('categories', $category->toArray());
    }

    /** @test */
    public function unauthenticate_can_not_delete_category()
    {
        $id = -1;
        $response = $this->delete($this->getDeleteCategoryRoute($id));
        $response->assertStatus(Response::HTTP_FOUND);
    }
}
