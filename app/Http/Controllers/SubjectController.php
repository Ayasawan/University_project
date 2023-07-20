<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
   
    public function index()
    {
        $Subject = SubjectResource::collection(Subject::get());
        return $this->apiResponse($Subject, 'ok', 200);
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make( $input, [
            'subject_name' => 'required',
            'semester' => 'required',
            'year' => 'required',
            'specialization' => 'required',
            'doctor_id' =>$request->doctor_id,

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $Subject =Subject::create($request->all());

        if ($Subject) {
            return $this->apiResponse(new SubjectResource($Subject), 'the Subject  save', 201);
        }
        return $this->apiResponse(null, 'the Subject  not save', 400);
    }

    
    public function show(Subject $subject)
    {
        $Subject= Subject::find($id);
        if($Subject){
            return $this->apiResponse(new SubjectResource($Subject) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the Subject not found' ,404);
    }

    
    public function update(Request $request, Subject $subject)
    {
        $Subject= Subject::find($id);
        if(!$Subject)
        {
            return $this->apiResponse(null ,'the Subject not found ',404);
        }
        $Subject->update($request->all());
        if($Subject)
        {
            return $this->apiResponse(new SubjectResource($Subject) , 'the Subject update',201);

        }
    }


    public function destroy(Subject $subject)
    {
        $Subject = Subject::find($id);
        if(!$Subject)
        {
            return $this->apiResponse(null ,'the Subject not found ',404);
        }
        $Subject->delete($id);
        if($Subject)
            return $this->apiResponse(null ,'the Subject delete ',200);
    }
}
