<?php

namespace App\Http\Controllers;
use Illuminate\Auth\AuthenticationException;
use App\Http\Resources\AdvertisementResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AdvertisementController extends Controller
{
    use  ApiResponseTrait;
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
            

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $Advertisement = Advertisement::query()->create([
            'content' => $request->content,
            'employee_id' => auth()->id(),
        ]);
       
        if ($Advertisement) {
            return $this->apiResponse(new AdvertisementResource($Advertisement), 'the Advertisement  save', 201);
        }
        return $this->apiResponse(null, 'the Advertisement  not save', 400);

    }

  
    public function show( $id)
    {
        $Advertisement= Advertisement::find($id);
        if($Advertisement){
            return $this->apiResponse(new AdvertisementResource($Advertisement) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the Advertisement not found' ,404);
    }

  
    public function update(Request $request,  $id)
    {
        $Advertisement= Advertisement::find($id);
        if(!$Advertisement)
        {
            return $this->apiResponse(null ,'the Advertisement not found ',404);
        }
        if($Advertisement->employee_id !=Auth::id() ){
            return $this->apiResponse(null, 'you do not have rights', 400);
        }
        $Advertisement->update($request->all());
        if($Advertisement)
        {
            return $this->apiResponse(new AdvertisementResource($Advertisement) , 'the Advertisement update',201);

        }


        
    }


 
    public function destroy($id)
    {
        $Advertisement = Advertisement::find($id);
               if(!$Advertisement)
               {
                   return $this->apiResponse(null ,'the Advertisement not found ',404);
               }
               if($Advertisement->employee_id !=Auth::id()  ){
                return $this->apiResponse(null, 'you do not have rights', 400);
               }
               $Advertisement->delete($id);
               if($Advertisement)
                   return $this->apiResponse(null ,'the Advertisement delete ',200);
           
    }
}
