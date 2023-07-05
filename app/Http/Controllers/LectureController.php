<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    
    public function index()
    {
        $Lecture = LectureResource::collection(Lecture::get());
        return $this->apiResponse($Lecture, 'ok', 200);
    }

   
    public function store(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make( $input, [
            'lecture_name' => 'required',
            'pdf' => 'required',
            'type' => 'required',
            'subject_id' =>$request->subject_id,

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $Lecture =Lecture::create($request->all());

        if ($Lecture) {
            return $this->apiResponse(new LectureResource($Lecture), 'the Lecture  save', 201);
        }
        return $this->apiResponse(null, 'the Lecture  not save', 400);
    }

 
    public function show(Lecture $lecture)
    {
        $Lecture= Lecture::find($id);
        if($Lecture){
            return $this->apiResponse(new LectureResource($Lecture) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the Lecture not found' ,404);
    }


    public function update(Request $request, Lecture $lecture)
    {
        $Lecture= Lecture::find($id);
        if(!$Lecture)
        {
            return $this->apiResponse(null ,'the Lecture not found ',404);
        }
        $Lecture->update($request->all());
        if($Lecture)
        {
            return $this->apiResponse(new LectureResource($Lecture) , 'the Lecture update',201);

        }
    }

 
    public function destroy(Lecture $lecture)
    {
        $Lecture = Lecture::find($id);
        if(!$Lecture)
        {
            return $this->apiResponse(null ,'the Lecture not found ',404);
        }
        $Lecture->delete($id);
        if($Lecture)
            return $this->apiResponse(null ,'the Lecture delete ',200);
    }
}
