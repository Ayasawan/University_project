<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObjectionResource extends JsonResource
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
            "subject_name"=>$this->subjectName,
            "yearyear"=>$this->year,
            "semester"=>$this->semester,
            "type"=>$this->year,
            "oldMark"=>$this->year,
            "information_user"=>$this->User()->get(),
        ];

    }
}
