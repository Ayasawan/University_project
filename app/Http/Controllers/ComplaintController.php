<?php

namespace App\Http\Controllers;

use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    use  ApiResponseTrait;

    public function index()
    {
        $Complaint = ComplaintResource::collection(Complaint::get());
        return $this->apiResponse($Complaint, 'ok', 200);
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make( $input, [
            'content' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $Complaint =Complaint::create($request->all());

        if ($Complaint) {
            return $this->apiResponse(new ComplaintResource($Complaint), 'the Complaint  save', 201);
        }
        return $this->apiResponse(null, 'the Complaint  not save', 400);
    }

    public function show($id)
    {
        $Complaint= Complaint::find($id);
        if($Complaint){
            return $this->apiResponse(new ComplaintResource($Complaint) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the Complaint not found' ,404);

    }


    public function update(Request $request,  $id)
    {
        $Complaint= Complaint::find($id);
        if(!$Complaint)
        {
            return $this->apiResponse(null ,'the Complaint not found ',404);
        }
        $Complaint->update($request->all());
        if($Complaint)
        {
            return $this->apiResponse(new ComplaintResource($Complaint) , 'the Complaint update',201);

        }
    }



    public function destroy( $id)
    {
        $Complaint = Complaint::find($id);
        if(!$Complaint)
        {
            return $this->apiResponse(null ,'the Complaint not found ',404);
        }
        $Complaint->delete($id);
        if($Complaint)
            return $this->apiResponse(null ,'the Complaint delete ',200);
    }

}
