<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = ['name', 'price', 'description', 'image'];

    public function categories()
    {
        return  $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id');
    }

    public function scopeWithName($query, $name)
    {
        return $name ? $query->where('name', 'LIKE', '%' . $name . '%') : null;
    }

    public function scopeWithPrice($query, $price)
    {
        return $price ? $query->where('price', 'LIKE', '%' . $price . '%') : null;
    }

    public function scopeWithCategoryName($query, $categoryName)
    {
        return $categoryName ? $query->whereHas('categories', fn ($query) =>
        $query->where('name', 'LIKE', '%' . $categoryName . '%')) : null;
    }
}
