<?php

namespace App\Http\Controllers;

use App\Models\Objection;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Resources\ObjectionResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class ObjectionController extends Controller
{
    use  ApiResponseTrait;
    public function index()
    {
        $objection = ObjectionResource::collection(Objection::get());
        return $this->apiResponse($objection, 'ok', 200);
    }

    
    public function indexfor1User()
    {
        $user = Auth::user(); // Get the authenticated user
        $objection = $user->Objections;
        return $this->apiResponse($objection, 'ok', 200);
      
    }



  
   
    public function store(Request $request)
    {

        $input=$request->all();
        $validator = Validator::make( $input, [
            'year' => 'required',
            'semester'=> 'required',
            'subjectName' => 'required',
            'type' => 'required',
            'oldMark' => 'required',


        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $objection =Objection::create([
            'date' => Carbon::now(),
            'year' => $request->year,
            'semester' => $request->semester,
            'subjectName' => $request->subjectName,
            'type' => $request->type,
            'oldMark' => $request->oldMark,
            'user_id' => Auth::id(),
        ]);

        if ($objection) {
            return $this->apiResponse(new ObjectionResource($objection), 'the objection  save', 201);
        }
        return $this->apiResponse(null, 'the objection  not save', 400);    }

    

    public function show($id)
    {
        $objection= Objection::find($id);
        if($objection){
            return $this->apiResponse(new ObjectionResource($objection) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the objection not found' ,404);

    }

  

   
    public function update(Request $request, $id)
    {
        $objection= Objection::find($id);
        if(!$objection)
        {
            return $this->apiResponse(null ,'the objection not found ',404);
        }
        $objection->update($request->all());
        if($objection)
        {
            return $this->apiResponse(new ObjectionResource($objection) , 'the objection update',201);

        }    }

        
   
    public function update_user(Request $request, $id)
    {
        $objection= Objection::find($id);
        if(!$objection)
        {
            return $this->apiResponse(null ,'the objection not found ',404);
        }
        if($objection->user_id !=Auth::id()){
            return $this->apiResponse(null, 'you do not have rights', 400);
        }
        $objection->update($request->all());
        if($objection)
        {
            return $this->apiResponse(new ObjectionResource($objection) , 'the objection update',201);

        }   
     }


    
    public function destroy($id)
    {
        $objection = Objection::find($id);
        if(!$objection)
        {
            return $this->apiResponse(null ,'the objection not found ',404);
        }
        $objection->delete($id);
        if($objection)
            return $this->apiResponse(null ,'the objection delete ',200);
    }


    public function destroy_user($id)
    {
        $objection = Objection::find($id);
        if(!$objection)
        {
            return $this->apiResponse(null ,'the objection not found ',404);
        }
        if($objection->user_id !=Auth::id()){
            return $this->apiResponse(null, 'you do not have rights', 400);
        }
        $objection->delete($id);
        if($objection)
            return $this->apiResponse(null ,'the objection delete ',200);
    }
}
