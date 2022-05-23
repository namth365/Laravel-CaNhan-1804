<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\CategoryService;
use Image;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->search($request);
        $categories = $this->categoryService->all();
        $parent = $this->categoryService->getParentCategory();

        return view('products.index', compact('products', 'categories', 'parent'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->create($request);

        return redirect(route('products.index'));
    }

    public function edit($id)
    {
        $product = $this->productService->findOrFail($id);
        $productResource = new ProductResource($product);

        return $this->sentSuccessResponse($productResource, 'success', Response::HTTP_OK);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->update($request, $id);
        $productResource = new ProductResource($product);

        return $this->sentSuccessResponse($productResource, 'success', Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $this->productService->delete($id);

        return redirect(route('products.index'));
    }
}
