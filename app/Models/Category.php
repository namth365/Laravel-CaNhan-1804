<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table ="categories";
    protected $fillable = ['name','parent_id'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    /**
     * The products that belong to the category.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'categories_products');
    }
    /**
     * Scope a query to search category by name.
    */
    public function scopeWithName($query, $name)
    {
        return $name ? $query->where('name', 'LIKE', '%' . $name . '%') : null;
    }
}
