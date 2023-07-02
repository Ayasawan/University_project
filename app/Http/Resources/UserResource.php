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
        
           "FirstName" => $this->FirstName,
            "LastName" => $this->LastName,
            "FatherName" => $this->FatherName,
            "MotherName" => $this->MotherName,
            "Specialization" => $this->Specialization,
            "Year" => $this->Year,
            "Birthday" => $this->Birthday,
            "BirthPlace"=> $this->BirthPlace,
            "Gender" => $this->Gender,
            "Location" => $this->Location,
            "Phone" => $this->Phone,
            "ExamNumber" => $this->ExamNumber,
            "Average" => $this->Average,
            "NationalNumber" => $this->NationalNumber,
            "email"=>$this->email,
            "password"=>$this->password,
           // "products  of user"=>$this->products()->get(),
        ];


}
}
