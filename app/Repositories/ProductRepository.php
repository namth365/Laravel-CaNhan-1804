<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function getModel()
    {
        return Product::class;
    }

    public function search($dataSearch)
    {
        return $this->model->withName($dataSearch['name'])
                           ->withPrice($dataSearch['price'])
                           ->withCategoryName($dataSearch['category_name'])
                           ->paginate(5);
    }
}
