<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use WithoutMiddleware;

    public function getUpdateProductRoute($id)
    {
        return route('products.update', $id);
    }

    public function getRedirecProductRoute()
    {
        return route('products.index');
    }

    /** @test */
    public function authenticate_can_update_product()
    {
        $this->login(["manage"]);
        $product = Product::factory()->create();
        $dataUpdate =Product::factory()->make(['parent_id'=> 2])->toArray();
        $response = $this->post($this->getUpdateProductRoute($product->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('data', fn (AssertableJson $json) =>
        $json->where('name', $dataUpdate['name'])
            ->etc())->etc());
        $this->assertDatabaseHas('products', [
            'name' => $dataUpdate['name'],
            'price' => $dataUpdate['price'],
            'description' => $dataUpdate['description'],
        ]);
    }

    /** @test */
    public function authenticate_can_not_edit_product_if_name_is_null()
    {
        $this->login(["manage"]);
        $product = Product::factory()->create();
        $dataUpdate = Product::factory()->make(['name' => null])->toArray();
        $response = $this->post($this->getUpdateProductRoute($product->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function authenticate_can_not_edit_product_if_price_is_null()
    {
        $this->login(["manage"]);
        $product = Product::factory()->create();
        $dataUpdate = Product::factory()->make(['price' => null])->toArray();
        $response = $this->post($this->getUpdateProductRoute($product->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['price']);
    }

    /** @test */
    public function authenticate_can_not_edit_product_if_description_is_null()
    {
        $this->login(["manage"]);
        $product = Product::factory()->create();
        $dataUpdate = Product::factory()->make(['description' => null])->toArray();
        $response = $this->post($this->getUpdateProductRoute($product->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['description']);
    }
}
