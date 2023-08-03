<?php

namespace App\Http\Controllers;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
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
            'title' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $Complaint = Complaint::query()->create([
            'content' => $request->content,
            'title' => $request->title,
            'user_id' => auth()->id(),
        ]);

        // $user =Auth::user();
        // $input['user_id']=$user->id;
        // $Complaint =Complaint::create($input);

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
        if($Complaint->user_id !=Auth::id()){
            return $this->apiResponse(null, 'you do not have rights', 400);
        }
        $Complaint->update($request->all());
        if($Complaint)
        {
            return $this->apiResponse(new ComplaintResource($Complaint) , 'the Complaint update',201);

        }
    }


   public function destroy( $id)
    {
        $complaint =  Complaint::find($id);

        if(!$complaint){
            return $this->apiResponse(null, 'This Complaint not found', 404);
        }
        if($complaint->user_id !=Auth::id()){
            return $this->apiResponse(null, 'you do not have rights', 400);

        }
        $complaint->delete($id);
            return $this->apiResponse(null, 'This complaint deleted', 200);

    }

}
