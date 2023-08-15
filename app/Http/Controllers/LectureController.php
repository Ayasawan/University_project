<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Subject;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Resources\LectureResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    use  ApiResponseTrait;
    public function index($id)
    {
        $Subject = Subject::find($id);
        $Lectures = $Subject->lectures;
        return $this->apiResponse($Lectures, 'ok', 200);
    }

   
    public function store(Request $request,$id)
    {

         // Get the authenticated doctor
         $doctor = $request->user();

         // Check if the doctor has the specified subject in their list of assigned subjects
         if ($doctor && $doctor->doctorHasSubject($id)) {

            $input=$request->all();
            $validator = Validator::make( $input, [
                'lecture_name' => 'required',
                'pdf' => 'required',
                'type' => 'required',
            // 'subject_id' =>$request->subject_id,

            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }

            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('PDF/Lecture'), $fileName);
            
            }
        
            

                $Subject = Subject::find($id);
                if (!$Subject) {
                    return $this->apiResponse(null, 'this Subject not found', 404);
                }
                $Lecture = $Subject->lectures()->create([
                    'lecture_name' => $request->input('lecture_name'),
                    'pdf' => $fileName,
                    'type' => $request->input('type'),
                    'subject_id' =>$id,
                
                ]);
           

        if ($Lecture) {
            return $this->apiResponse(new LectureResource($Lecture), 'the Lecture  save', 201);
        }
        return $this->apiResponse(null, 'the Lecture  not save', 400);
    }
        else {
            // Doctor does not have the subject, return an error response
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

 
    public function show($id,$id2)
    {
        $Subject = Subject::find($id);
        if (!$Subject) {
            return $this->apiResponse(null, 'this Subject not found', 404);
        }
        $Lecture = $Subject->lectures()->where('id', $id2)->first();
        if($Lecture){
            return $this->apiResponse(new LectureResource($Lecture) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the Lecture not found' ,404);
    }


    public function update(Request $request, $id,$id2)
    {
        $Subject = Subject::find($id);
        if (!$Subject) {
            return $this->apiResponse(null, 'this Subject not found', 404);
        }
        $Lecture= Lecture::find($id2);
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

 
    public function destroy($id, $id2)
    {
        $Subject = Subject::find($id);
        if (!$Subject) {
            return $this->apiResponse(null, 'this Subject not found', 404);
        }
        $Lecture= Lecture::find($id2);
        if(!$Lecture)
        {
            return $this->apiResponse(null ,'the Lecture not found ',404);
        }
        $Lecture->delete($id2);
        if($Lecture)
            return $this->apiResponse(null ,'the Lecture delete ',200);
    }


    public function downloadPDF($id)
    {
        $Lecture = Lecture::find($id);
        if (!$Lecture) {
            abort(404);
        }
        $pdfPath = public_path('PDF/Lecture/' . $Lecture->PDF); // assumes that the PDF files are stored in the public/PDF/Mark directory
        if (!file_exists($pdfPath)) {
            abort(404);
        }
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $Lecture->PDF . '"',
        ];
        return response()->download($pdfPath, $Lecture->PDF, $headers);
    }
}
