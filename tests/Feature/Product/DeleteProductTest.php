<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{

    use WithoutMiddleware;

    public function getDeleteProductRoute($id)
    {
        return route('products.destroy', $id);
    }

    /** @test */
    public function authenticate_can_delete_product()
    {
        $this->login(["manage"]);
        $product = Product::factory()->create();
        $countProductBefore = Product::count();
        $response = $this->get($this->getDeleteProductRoute($product->id));
        $countProductAfter = Product::count();
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals($countProductBefore - 1, $countProductAfter);
        $this->assertDatabaseMissing('products', $product->toArray());
    }

    /** @test */
//    public function authenticate_can_not_delete_product()
//    {
//        $deleteId = -1;
//        $response = $this->post($this->getDeleteProductRoute($deleteId));
//        $response->assertStatus(Response::HTTP_NOT_FOUND);
//    }
}

