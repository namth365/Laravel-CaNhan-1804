<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'categories' => new CategoryCollection($this->categories),
            'edit_url' => route('products.edit', $this->id),
            'update_url' => route('products.update', $this->id),
            'destroy_url' => route('products.destroy', $this->id)
        ];
    }
}
