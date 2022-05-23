<?php
namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Traits\HandleImage;
use Illuminate\Http\Request;

class ProductService
{
    use HandleImage;
    /**
     * @var $ProductRepository
     */
    protected $productRepository;
    /**
     * PostService constructor.
     *
     * @param ProductRepository $productRepository;
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get All post
     * @return String
     */

    public function all()
    {
        return $this->productRepository->getAll();
    }

    public function search(Request $request)
    {
        if ($request['name'] != null || $request['price'] != null || $request['category_name'] != null) {
            return $this->productRepository->search($request);
        }
        return $this->productRepository->paginate(5);
    }

    public function create(StoreProductRequest $request)
    {
        $dataCreate = $request->all();
        $dataCreate['image'] = $this->storeImage($request);
        $product = $this->productRepository->create($dataCreate);
        if (!empty($request->parent_id)) {
            $product->categories()->attach($dataCreate['parent_id']);
        }
        return $product;
    }

    public function findOrFail($id)
    {
        return $this->productRepository->findOrFail($id);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        if ($request->image == null) {
            unset($request->image);
            $dataUpdate = $request->all();
        } else {
            $product = $this->productRepository->findOrFail($id);
            $dataUpdate = $request->all();
            $dataUpdate['image'] = $this->updateImage($request, $product->image);
        }
        $product = $this->productRepository->update($dataUpdate, $id);
        if ($request->parent_id == 0) {
            unset($request->parent_id);
        } else {
            if (!empty($request->parent_id)) {
                $product->categories()->sync($request->parent_id);
            } else {
                $product->categories()->detach();
            }
            return $product;
        }
    }

    public function delete($id): int
    {
        $product = $this->productRepository->find($id);
        $this->deleteImage($product->image);
        return $this->productRepository->delete($id);
    }
}
