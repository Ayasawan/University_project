<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
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

   

        // public function downloadPDF($id)
        // {
        //     $mark = Mark::find($id);
        //     if (!$mark) {
        //         abort(404);
        //     }
        //     $pdfData = $mark->PDF; // assumes that the PDF data is stored in a 'pdf_data' column in the 'marks' table
        //     if (!$pdfData) {
        //         abort(404);
        //     }
        //     $headers = [
        //         'Content-Type' => 'application/pdf',
        //         'Content-Disposition' => 'attachment; filename="' . $mark->PDF . '"',
        //     ];
        //     return response()->download($pdfData, $mark->PDF, $headers);
        // }

        public function downloadPDF($id)
        {
            $mark = Mark::find($id);
            if (!$mark) {
                abort(404);
            }
            $pdfPath = public_path('PDF/Mark/' . $mark->PDF); // assumes that the PDF files are stored in the public/PDF/Mark directory
            if (!file_exists($pdfPath)) {
                abort(404);
            }
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $mark->PDF . '"',
            ];
            return response()->download($pdfPath, $mark->PDF, $headers);
        }

}


