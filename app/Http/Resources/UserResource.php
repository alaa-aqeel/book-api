<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "fullname" => $this->fullname,
            "email" => $this->email,
            "is_admin" => $this->is_admin,
            "created_at" => $this->when(auth()->user()->is_admin, $this->created_at)
        ];
    }
}
