<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyMarkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
  
        public function rules()
      {
            return [
            // Validate that marks is an array 
            'marks' => 'required| array',
            
            // Validate each element of marks array 
            'marks.*.nameMark' => 'required| string', 

            'marks.* .markNum' => 'required| string',

            'marks.*.year' => 'required in:'. implode(',',
            MyMarks::getAllowedYears ()),

            // Validate that semester is one of the allowed values 
            'marks.*.semester' => 'required in:'. implode(',',
            MyMarks::getAllowedSemesters ()),

            'marks.*.user_id' => 'required| exists:users,id',
            ];
    }




}
