<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
  
    public function index()
    {
        $Advertisement = AdvertisementResource::collection(Advertisement::get());
        return $this->apiResponse($Advertisement, 'ok', 200);
    }

 
    public function store(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make( $input, [
            'content' => 'required',
            'employee_id' => 'required',
            'doctor_id' =>$request->doctor_id,

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $Advertisement =Advertisement::create($request->all());

        if ($Advertisement) {
            return $this->apiResponse(new AdvertisementResource($Advertisement), 'the Advertisement  save', 201);
        }
        return $this->apiResponse(null, 'the Advertisement  not save', 400);
    }

  
    public function show(Advertisement $advertisement)
    {
        $Advertisement= Advertisement::find($id);
        if($Advertisement){
            return $this->apiResponse(new AdvertisementResource($Advertisement) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the Advertisement not found' ,404);
    }

  
    public function update(Request $request, Advertisement $advertisement)
    {
        $Advertisement= Advertisement::find($id);
        if(!$Advertisement)
        {
            return $this->apiResponse(null ,'the Advertisement not found ',404);
        }
        $Advertisement->update($request->all());
        if($Advertisement)
        {
            return $this->apiResponse(new AdvertisementResource($Advertisement) , 'the Advertisement update',201);

        }
    }

 
    public function destroy(Advertisement $advertisement)
    {
        $Advertisement = Advertisement::find($id);
               if(!$Advertisement)
               {
                   return $this->apiResponse(null ,'the Advertisement not found ',404);
               }
               $Advertisement->delete($id);
               if($Advertisement)
                   return $this->apiResponse(null ,'the Advertisement delete ',200);
    }
}
