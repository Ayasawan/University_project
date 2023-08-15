<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    use  ApiResponseTrait;
    public function index()
    {
        $schedule = ScheduleResource::collection(Schedule::get());
        return $this->apiResponse($schedule, 'ok', 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'PDF' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
    
        if ($request->hasFile('PDF')) {
            $file = $request->file('PDF');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('PDF/Schedule'), $fileName);
           
            $schedule = Schedule::create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'PDF' => $fileName,
                'Employee_id' => auth()->id(),
              
            ]);
    
            if ($schedule) {
                return response()->json(['message' => 'File uploaded and schedule saved successfully'], 200);
            }
        }
    
        return response()->json(['message' => 'Error in uploading file or saving schedule'], 400);
    }





    public function show($id)
    {
        $schedule= Schedule::find($id);
        if($schedule){
            return $this->apiResponse(new ScheduleResource($schedule) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the schedule not found' ,404);

    }




    // public function update(Request $request,  $id)
    // {
    //     $schedule= Schedule::find($id);
    //     if(!$schedule)
    //     {
    //         return $this->apiResponse(null ,'the schedule not found ',404);
    //     }

        

    //     if ($request->hasFile('PDF')) {
    //         $file = $request->file('PDF');
    //         $fileName = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('PDF'), $fileName);

    //     $schedule->update($request->all());
    //     if($schedule)
    //     {
    //         return $this->apiResponse(new ScheduleResource($schedule) , 'the schedule update',201);

    //     }}
    // }




    // $schedule = Schedule::find($id);
    // if (!$schedule) {
    //     return $this->apiResponse(null, 'The schedule was not found', 404);
    // }

    // if ($request->hasFile('PDF')) {
    //     $file = $request->file('PDF');
    //     $fileName = time() . '_' . $file->getClientOriginalName();
    //     $file->move(public_path('PDF'), $fileName);
    //     $schedule->PDF = $fileName;
    // }

    // $schedule->fill($request->all());
    // $schedule->save();

    // return $this->apiResponse(new ScheduleResource($schedule), 'The schedule has been updated', 201);





    public function destroy( $id)
    {
        $schedule = Schedule::find($id);
        if(!$schedule)
        {
            return $this->apiResponse(null ,'the schedule not found ',404);
        }
        $schedule->delete($id);
        if($schedule)
            return $this->apiResponse(null ,'the schedule delete ',200);
    }


}
