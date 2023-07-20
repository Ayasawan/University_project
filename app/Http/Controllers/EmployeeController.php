<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use  ApiResponseTrait;

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
}
