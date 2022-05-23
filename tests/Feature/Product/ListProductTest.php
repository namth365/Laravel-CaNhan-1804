<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Http\Response;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    public function getListProductRoute()
    {
        return route('products.index');
    }

    /** @test */
    public function authenticate_can_get_list_product()
    {
        $this->login(["manage"]);
        $response = $this->get($this->getListProductRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('products.index');
    }

    /** @test */
    public function unauthenticated_can_not_list_role()
    {
        $user = Product::factory()->create();
        $response = $this->get($this->getListProductRoute());
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticate_can_product_list_search()
    {
        $this->login(["manage"]);
        $product = $this->getDataValid(['name'=>'Quần Jean Nam 2022']);
        $response = $this->get($this->getListProductRoute(), $product);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('products', ['name' => $product['name']]);
        $response->assertSee(['name']);
        $response->assertViewIs('products.index');
    }

    /** @test */
    public function authenticate_can_not_product_list_search()
    {
        $this->login(["manage"]);
        $product = $this->getDataValid();
        $response = $this->get($this->getListProductRoute(), $product);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('products', ['name' => $product['name']]);
        $response->assertSee(['name']);

        $response->assertViewIs('products.index');
    }

    public function getDataValid($dataSearchProduct = [])
    {
        $dataSearchProductFake = [
            'name' => $this->faker->name,
            'price' => rand(100, 200),
            'category_name'=>$this->faker->text(10)
        ];
        return array_merge($dataSearchProductFake, $dataSearchProduct);
    }
}
