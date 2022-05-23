<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function getModel()
    {
        return Category::class;
    }

    public function search($dataSearch)
    {
        return $this->model->withName($dataSearch['name'])
                           ->paginate(5);
    }

    public function getParentCategory()
    {
        return $this->model->where('parent_id', null)->orderby('name', 'asc')->get();
    }

    public function getParentCategoryWithout($id)
    {
        return $this->model->where('parent_id', null)
                           ->where('id', '!=', $id)->orderby('name', 'asc')->get();
    }
}
