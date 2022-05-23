<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService
{
    /**
     * @var CategoryRepository $CategoryRepository
     */
    protected CategoryRepository $categoryRepository;
    /**
     * PostService constructor.
     *
     * @param CategoryRepository $categoryRepository;
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get All post
     * @return String
     */

    public function all()
    {
        return $this->categoryRepository->getAll();
    }

    public function search(Request $request)
    {
        if ($request['name'] != null) {
            return $this->categoryRepository->search($request);
        }
        return $this->categoryRepository->paginate(5);
    }

    public function getParentCategory()
    {
        return $this->categoryRepository->getParentCategory();
    }

    public function getParentCategoryWithout($id)
    {
        return $this->categoryRepository->getParentCategoryWithout($id);
    }

    public function findOrFail($id)
    {
        return $this->categoryRepository->findOrFail($id);
    }

    public function create(StoreCategoryRequest $request)
    {
        return  $this->categoryRepository->create($request->all());
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
         return $this->categoryRepository->update($request->all(), $id);
    }
    public function delete($id): int
    {
        return $this->categoryRepository->delete($id);
    }
}
