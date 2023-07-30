<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetectingMarkResource;
use App\Models\DetectingMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DetectingMarkController extends Controller
{
    use  ApiResponseTrait;
    public function index()
    {
        $DetectingMark = DetectingMarkResource::collection(DetectingMark::get());
        return $this->apiResponse($DetectingMark, 'ok', 200);
    }


    public function store(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make( $input, [
            'MatherName' => 'required',
            'FatherName'=> 'required',
            'BirthPlace' => 'required',
            'FirstName' => 'required',
            'LastName' => 'required',


        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $DetectingMark =DetectingMark::create([
            'FatherName' => $request->FatherName,
            'MatherName' => $request->MatherName,
            'BirthPlace' => $request->BirthPlace,
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
            'user_id' => Auth::id(),
        ]);

        if ($DetectingMark) {
            return $this->apiResponse(new DetectingMarkResource($DetectingMark), 'the DetectingMark  save', 201);
        }
        return $this->apiResponse(null, 'the DetectingMark  not save', 400);
    }


    public function show($id)
    {
        $DetectingMark= DetectingMark::find($id);
        if($DetectingMark){
            return $this->apiResponse(new DetectingMarkResource($DetectingMark) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the DetectingMark not found' ,404);

    }


    public function update(Request $request,  $id)
    {
        $DetectingMark= DetectingMark::find($id);
        if(!$DetectingMark)
        {
            return $this->apiResponse(null ,'the DetectingMark not found ',404);
        }
        $DetectingMark->update($request->all());
        if($DetectingMark)
        {
            return $this->apiResponse(new DetectingMarkResource($DetectingMark) , 'the DetectingMark update',201);

        }
    }

    public function destroy( $id)
    {
        $DetectingMark = DetectingMark::find($id);
        if(!$DetectingMark)
        {
            return $this->apiResponse(null ,'the DetectingMark not found ',404);
        }
        $DetectingMark->delete($id);
        if($DetectingMark)
            return $this->apiResponse(null ,'the DetectingMark delete ',200);
    }

}
