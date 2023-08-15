<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\MyMarks;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\Http\Resources\MyMarksResource;
use App\Http\Requests\MyMarkRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Imports\MarksImport;
use Maatwebsite\Excel\Facades\Excel;

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

        public function indexfor1Userbyuser()
        {
            $user = Auth::user(); // Get the authenticated user
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
    
    
    

    //    public function calculateAverageForYear(Request $request)
    //    {
    //        $year = $request->input('year');
           
    //        $userId = Auth::id();
           
    //        $averages = MyMark::where('user_id', $userId)
    //            ->whereYear('created_at', $year)
    //            ->whereIn('semester', ['first', 'second'])
    //            ->select('nameMark', 'semester', 'markNum')
    //            ->get();
           
    //        $averageMarks = [];
           
    //        foreach ($averages as $average) {
    //            $key = $average->nameMark . '-' . $average->semester;
    //            $averageMarks[$key] = $average->markNum;
    //        }
           
    //        $average = array_sum($averageMarks) / count($averageMarks);
           
    //        return response()->json(['year' => $year, 'average' => $average]);
    //    }



       protected function calculateAverageForYear($year)
       {
        $userId = Auth::id();
           $averages = MyMarks::where('user_id', $userId)
               ->whereYear('created_at', $year)
               ->whereIn('semester', ['first', 'second'])
               ->select('nameMark', 'semester', 'markNum')
               ->get();
           
           $averageMarks = [];
           $marksBySubject = [];
        
           foreach ($averages as $average) {
               $key = $average->nameMark . '-' . $average->semester;
               $averageMarks[$key] = $average->markNum;
               $marksBySubject[$average->nameMark][] = [
                   'semester' => $average->semester,
                   'mark' => $average->markNum
               ];
           }
           
           $average = array_sum($averageMarks) / count($averageMarks);
           
           return ['average' => $average, 'marks_by_subject' => $marksBySubject];
       }
   



       public function calculateAverageForAllYears()
        {
            $userId = Auth::id();
            
            // $years = MyMarks::where('user_id', $userId)
            //     ->selectRaw('YEAR(created_at) as year')
            //     ->groupBy('year')
            //     ->pluck('year');
                
                
                $years = MyMarks::where('user_id', $userId)
                ->selectRaw('YEAR(created_at) as year, created_at')
                ->groupBy('year', 'created_at')
                ->pluck('year');
            
            $averagesByYear = [];
            
            foreach ($years as $year) {
                $averagesByYear[$year] = $this->calculateAverageForYear($year, $userId);
            }
            
            return response()->json(['averages_by_year' => $averagesByYear]);
        }



        public function importFileMark(Request $request) {
            $file = request()->file('file');
        
          //  (new MarksImport)->import($file);
            Excel::import(new MarksImport,$file);
            return $this->apiResponse(null ,'the Marks imported successfully. ',200);
            //return redirect()->back()->with('success', 'Marks imported successfully.');
        }


        public function import() 
        {
            Excel::import(new UsersImport, 'users.xlsx');
            
            return redirect('/')->with('success', 'All good!');
        }
}
