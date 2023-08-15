<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employee;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\Http\Resources\DoctorResource;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use  ApiResponseTrait;


    public function index()
    {
        $user = UserResource::collection(User::get());
        return $this->apiResponse($user, 'ok', 200);
    }

    public function AddUser(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make($input , [
            'FirstName'=>'required',
            'LastName'=>'required',
            'FatherName'=>'required',
            'MotherName'=>'required',
            'Specialization'=>'required',
            'Year'=>'required',
            'Birthday'=>'required',
            'BirthPlace'=>'required',
            'Gender'=>'required',
            'Location'=>'required',
            'Phone'=> ['required', 'string', 'min:10'],
            'ExamNumber'=>'required',
            'Average'=>'required',
            'NationalNumber'=>'required',
            // 'Birthday'=>'required',

            // 'phone'=> ['required', 'string', 'min:10'] ,

        ]);

        if ($validator->fails()){
            return $this->apiResponse(null,$validator ->errors() , 400);
        }

        $user =User::query()->create([
           // 'user_id'=>auth()->id(),
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
            'FatherName' => $request->FatherName,
            'MotherName' => $request->MotherName,
            'Specialization' => $request->Specialization,
            'Year' => $request->Year,
            'Birthday' => $request->Birthday,
            'BirthPlace' => $request->BirthPlace,
            'Gender' => $request->Gender,
            'Location' => $request->Location,
            'Phone' => $request->Phone,
            'ExamNumber' => $request->ExamNumber,
            'Average' => $request->Average,
            'NationalNumber' => $request->NationalNumber,
            'email'=>Str::random(10) . '@example.com',
            'password'=>Str::random(12),
         
        

        ]);
        if($user) {
            return $this->apiResponse(new UserResource($user), 'this student  is added', 201);
        }
        return $this->apiResponse(null, 'This student not save', 400);
    }



    public function updateUser(Request $request,  $id)
    {

       // dd($id);
        $user= User::find($id);
        if(!$user)
        {
            return $this->apiResponse(null ,'this student not found ',404);
        }
        $user->update($request->all());
        if($user)
        {
            return $this->apiResponse(new UserResource($user) , 'the student updated',201);

        }
    }



    public function showUser($id)
    {
        $user= User::find($id);
        if($user){
            return $this->apiResponse(new UserResource($user) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the user not found' ,404);

    }


    public function destroyUser( $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->apiResponse(null ,'the user not found ',404);
        }
        $user->delete($id);
        if($user)
            return $this->apiResponse(null ,'the user delete ',200);
    }














    ///doctor


    public function indexDoctor()
    {
        $doctor = DoctorResource::collection(Doctor::get());
        return $this->apiResponse($doctor, 'ok', 200);
    }
    public function AddDoctor(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make($input , [
            'first_name'=>'required',
            'last_name'=>'required',
            'gender'=>'required',
            'info'=>'required',
            'working_time'=>'required',
            'NationalNumber'=>'required',
        

        ]);

        if ($validator->fails()){
            return $this->apiResponse(null,$validator ->errors() , 400);
        }

        $doctor =Doctor::query()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'info' => $request->info,
            'working_time' => $request->working_time,
            'NationalNumber' => $request->NationalNumber,
            'email'=>Str::random(10) . '@example.com',
            'password'=>Str::random(12),
        ]);
        if($doctor) {
            return $this->apiResponse(new DoctorResource($doctor), 'this Doctor  is added', 201);
        }
        return $this->apiResponse(null, 'This doctor not save', 400);
    }

    
    public function updateDocdor(Request $request,  $id)
    {

        $doctor= Doctor::find($id);
        if(!$doctor)
        {
            return $this->apiResponse(null ,'this doctor not found ',404);
        }
        $doctor->update($request->all());
        if($doctor)
        {
            return $this->apiResponse(new DoctorResource($doctor) , 'the doctor updated',201);

        }
        
    }



    public function showDoctor($id)
    {
        $doctor= Doctor::find($id);
        if($doctor){
            return $this->apiResponse(new DoctorResource($doctor) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the doctor not found' ,404);

    }


    public function destroyDoctor( $id)
    {
        $doctor = Doctor::find($id);
        if(!$doctor)
        {
            return $this->apiResponse(null ,'the doctor not found ',404);
        }
        $doctor->delete($id);
        if($doctor)
            return $this->apiResponse(null ,'the doctor delete ',200);
    }



}
