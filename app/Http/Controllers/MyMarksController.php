<?php


namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employee;
use App\Models\MyMarks;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\Http\Resources\MyMarksResource;
use App\Http\Requests\MyMarkRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class MyMarksController extends Controller
{

    use  ApiResponseTrait;

    //
       public function storeAll (MyMarkRequest $request): JsonResponse
        {
        // The incoming request is valid...
        // Retrieve the validated input data...
        $validated = $request->validated();
        // Create a new mark from the validated data...
        $mark = MyMarks::create($validated);
        // Return a JSON response with the created mark and a 201 status code... 
        return response()->json ($mark, 201);
        }

       
        public function index()
        {
            $myMark = MyMarksResource::collection(MyMarks::get());
            return $this->apiResponse($myMark, 'ok', 200);
        }



        public function indexFor1User($id)
        {
            $user = User::find($id);
            $myMark = $user->MyMarks;
            return $this->apiResponse($myMark, 'ok', 200);
        }


    
        
        public function store(Request $request)
        {
            $input=$request->all();
            $validator = Validator::make( $input, [
                'nameMark' => 'required',
                'markNum' => 'required',
                'year' => 'required',
                'semester' => 'required',
                'user_id' => 'required',
    
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }
            $myMark =MyMarks::create($request->all());
    
            if ($myMark) {
                return $this->apiResponse(new MyMarksResource($myMark), 'the mark  save', 201);
            }
            return $this->apiResponse(null, 'the mark  not save', 400);
        }


    
        public function show($id)
        {
            $myMark= MyMarks::find($id);
            if($myMark){
                return $this->apiResponse(new MyMarksResource($myMark) , 'ok' ,200);
            }
            return $this->apiResponse(null ,'the mark not found' ,404);
    
        }
    
    
        public function update(Request $request,  $id)
        {
            $myMark= MyMarks::find($id);
            if(!$myMark)
            {
                return $this->apiResponse(null ,'the Mark not found ',404);
            }
            $myMark->update($request->all());
            if($myMark)
            {
                return $this->apiResponse(new MyMarksResource($myMark) , 'the mark update',201);
    
            }
        }
    
    
    //
       public function destroy( $id)
       {
           $myMark = MyMarks::find($id);
           if(!$myMark)
           {
               return $this->apiResponse(null ,'the Mark not found ',404);
           }
           $myMark->delete($id);
           if($myMark)
               return $this->apiResponse(null ,'the Mark delete ',200);
       }
    
    
    




}
