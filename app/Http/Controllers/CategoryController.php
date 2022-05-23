<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        foreach ($user->roles as $user) {
           $roles = $user->id; 
        } 
        $categories = $this->categoryService->search($request);

        return view('categories.index', compact('categories', 'roles'));
    }

    public function create()
    {
        $categories = $this->categoryService->getParentCategory();

        return view('categories.create', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->create($request);

        return redirect(route('categories.index'))->with('messenger', 'Create Category Success !');
    }

    public function edit($id)
    {
        $category = $this->categoryService->findOrFail($id);
        $categories = $this->categoryService->getParentCategoryWithout($category->id);

        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $this->categoryService->update($request, $id);

        return redirect(route('categories.index'))->with('messenger', 'Update Category Success !');
    }

    public function destroy($id)
    {
        $this->categoryService->delete($id);

        return redirect()->back()->with('messenger', 'Delete Category Success !');
    }
}
