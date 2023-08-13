<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetectingMarkResource extends JsonResource
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
            "FirstName"=>$this->FirstName,
            "LastName"=>$this->LastName,
            "FatherName"=>$this->FatherName,
            "MatherName"=>$this->MatherName,
            "BirthPlace"=>$this->BirthPlace,
            "information_user"=>$this->User()->get(),
        ];

    }
}
