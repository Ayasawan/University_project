<?php

namespace App\Http\Controllers;

use App\Http\Resources\RePracticalResource;
use App\Models\RePractical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RePracticalController extends Controller
{
    use  ApiResponseTrait;
    public function index()
    {
        $RePractical= RePracticalResource::collection(RePractical::get());
        return $this->apiResponse($RePractical, 'ok', 200);
    }


    public function store(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make( $input, [
            'semester' => 'required',
            'year' => 'required',
            'subject_name' => 'required',
//            'employee_id' => 'required',
//            'student_id'=> 'required',

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $RePractical =RePractical::create($request->all());

        if ($RePractical) {
            return $this->apiResponse(new RePracticalResource($RePractical), 'the RePractical  save', 201);
        }
        return $this->apiResponse(null, 'the RePractical  not save', 400);
    }


    public function show($id)
    {
        $RePractical= RePractical::find($id);
        if($RePractical){
            return $this->apiResponse(new RePracticalResource($RePractical) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the RePractical not found' ,404);

    }


    public function update(Request $request,  $id)
    {
        $RePractical= RePractical::find($id);
        if(!$RePractical)
        {
            return $this->apiResponse(null ,'the RePractical not found ',404);
        }
        $RePractical->update($request->all());
        if($RePractical)
        {
            return $this->apiResponse(new RePracticalResource($RePractical) , 'the RePractical update',201);

        }
    }

    public function destroy( $id)
    {
        $RePractical = RePractical::find($id);
        if(!$RePractical)
        {
            return $this->apiResponse(null ,'the RePractical not found ',404);
        }
        $RePractical->delete($id);
        if($RePractical)
            return $this->apiResponse(null ,'the RePractical delete ',200);
    }
}
