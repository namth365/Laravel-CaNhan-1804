<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateProductTest extends TestCase
{

    use WithoutMiddleware;

    public function getStoreProductRoute()
    {
        return route('products.store');
    }
    public function getRedirectProductRoute()
    {
        return route('products.index');
    }

    /** @test */
    public function authenticate_can_store_product()
    {
        $this->login(["manage"]);
        $dataCreate = Product::factory()->make()->toArray();
        $productBefore = Product::count();
        $response = $this->post($this->getStoreProductRoute(), $dataCreate);
        $productAfter = Product::count();
        $this->assertEquals($productBefore + 1, $productAfter);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect($this->getRedirectProductRoute());
    }

    /** @test */
    public function authenticate_can_not_store_product_if_name_null()
    {
        $this->login(["manage"]);
        $dataCreate = Product::factory()->make(['name' => ''])->toArray();
        $response = $this->post($this->getStoreProductRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function authenticate_can_not_store_product_if_price_null()
    {
        $this->login(["manage"]);
        $dataCreate = Product::factory()->make(['price' => ''])->toArray();
        $response = $this->post($this->getStoreProductRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['price']);
    }

    /** @test */
    public function authenticate_can_not_store_product_if_description_null()
    {
        $this->login(["manage"]);
        $dataCreate = Product::factory()->make(['description' => ''])->toArray();
        $response = $this->post($this->getStoreProductRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function authenticate_can_not_store_product_if_image_null()
    {
        $this->login(["manage"]);
        $dataCreate = Product::factory()->make(['image' => null])->toArray();
        $response = $this->post($this->getStoreProductRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['image']);
    }

    /** @test */
    public function authenticate_can_not_store_product_if_data_is_null()
    {
        $this->login(["manage"]);
        $dataCreate = Product::factory()->make(['name' =>null, 'price' => null, 'description' => null, 'image' => null])->toArray();
        $response = $this->post($this->getStoreProductRoute(), $dataCreate);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name','price','description','image']);
    }
}
