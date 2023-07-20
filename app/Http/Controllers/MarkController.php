<?php
namespace App\Http\Controllers;

use App\Http\Resources\MarkResource;
use App\Models\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarkController extends Controller
{
    use  ApiResponseTrait;
    public function index()
    {
        $mark = MarkResource::collection(Mark::get());
        return $this->apiResponse($mark, 'ok', 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'SubjectName' => 'required',
            'year' => 'required',
            'Specialization' => 'required',
            'PDF' => 'required',

        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
    
        if ($request->hasFile('PDF')) {
            $file = $request->file('PDF');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('PDF/Mark'), $fileName);
           
            $mark = Mark::create([
                'SubjectName' => $request->input('SubjectName'),
                'year' => $request->input('year'),
                'Specialization' => $request->input('Specialization'),
                'PDF' => $fileName,
                'Employee_id' => auth()->id(),
              
            ]);
    
            if ($mark) {
                return response()->json(['message' => 'File of Marks saved successfully'], 200);
            }
        }
    
        return response()->json(['message' => 'Error in uploading or saving file of marks'], 400);
    }





    public function show($id)
    {
        $mark= Mark::find($id);
        if($mark){
            return $this->apiResponse(new MarkResource($mark) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the file  of Marks not found' ,404);

    }






    public function destroy( $id)
    {
        $mark = Mark::find($id);
        if(!$mark)
        {
            return $this->apiResponse(null ,'the file of marks not found ',404);
        }
        $mark->delete($id);
        if($mark)
            return $this->apiResponse(null ,'the file of marks deleted ',200);
    }


}


