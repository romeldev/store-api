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
            'id' => $this->id,
            'name' => $this->name,
            'descrip' => $this->descrip,
            'price' => $this->price,
            'preice_ref' => $this->price_ref,
            'discount' => $this->discount,
            'category' => $this->category,
            'tags' => $this->tags,
            'photos' => PhotoResource::collection($this->photos),
        ];
    }
}
