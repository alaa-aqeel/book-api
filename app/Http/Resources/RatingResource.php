<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            "value" => $this->value,
            "comment" => $this->comment,
            "book" => $this->when($this->book, fn()=>[
                'id' => $this->book->id,
                'name' => $this->book->name,
            ]),
            "user" => $this->when($this->user, fn()=> [
                "id" =>  $this->user->id,
                "fullname" =>  $this->user->fullname,
                "email" =>  $this->user->email,
            ]),
            "created_at" => $this->created_at
        ];
    }
}
