<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "link" => $this->link,
            "image" => $this->image,
            "description" => $this->description,
            "language" => $this->language,
            "author" => $this->author,
            "pages" => $this->pages,
            "section" => $this->when($this->section, fn()=> $this->section->name),
            "ratings" => $this->ratings->avg('value')
        ];
    }
}
