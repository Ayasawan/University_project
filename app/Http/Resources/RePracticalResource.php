<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RePracticalResource extends JsonResource
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
            "subject_name"=>$this->subject_name,
            "yearyear"=>$this->year,
            "semester"=>$this->semester,
            "information_user"=>$this->User()->get(),
        ];

    }
}
