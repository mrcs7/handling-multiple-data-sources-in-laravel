<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'identifier' => $this->identifier,
            'description' => $this->description,
            'categories' => $this->categories,
            'prices' => $this->prices,
            'images' => $this->images
        ];
    }
}
