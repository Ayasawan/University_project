<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
        "id"=>$this->id,
        "user_id"=>$this->user_id,
         "title"=>$this->title,
            "content"=>$this->content,
            "comments of complaint"=>$this->comments()->get(),
            "likes of complaint"=>$this->likes()->get(),
        ];
            }
}
