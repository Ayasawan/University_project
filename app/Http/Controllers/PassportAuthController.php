<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\RefreshToken;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class PassportAuthController extends Controller
{

    use  ApiResponseTrait;




//user//student//auth
    public function userInfo()
    {

        $user = auth()->user();

        return response()->json(['user' => $user], 200);

    }



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'NationalNumber' => ['required', 'min:10', 'max:14', 'regex:/^[0-9]+$/', 'exists:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->NationalNumber.',NationalNumber'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 401);
        }

        $national = $request->NationalNumber;
        $user = User::where('NationalNumber', $national)->first();

        if (!$user) {
            return $this->apiResponse(null, 'Sorry, you do not have an account in this system', 404);
        }

        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        if ($tokenResult = $user->createToken('Personal Access Token')) {
            $data["message"] = 'User successfully registered';
            $data["user_type"] = 'user';
            $data["user"] = $user;
            $data["token_type"] = 'Bearer';
            $data["access_token"] = $tokenResult->accessToken;

            return response()->json($data, Response::HTTP_OK);
        }

        return response()->json(['error' => ['Email and Password are wrong.']], 401);
    }



    public function userLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
           // 'phone_number' => [  'string','min:9'],
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
//        if(!Auth::attempt(['email' => $email, 'password' => $password]) ||
//            (!Auth::attempt(['phone_number' => $phone_number, 'password' => $password]))){
        if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'user']);

            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success["user_type"] = 'user ';
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken;

            return response()->json($success, 200);
        }else{
            return response()->json(['error' => ['Email and Password are Wrong.']], 401);
        }
    }




    public function logout(Request $request)
    {
        Auth::guard('user-api')->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    // public function adminLogin(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json(['error' => $validator->errors()->all()]);
    //     }
    //     if(auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])){

    //         config(['auth.guards.api.provider' => 'admin']);
    //         $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
    //         $success =  $admin;
    //         $success['token'] =  $admin->createToken('MyApp',['admin'])->accessToken;

    //         return response()->json($success, 200);
    //     }else{
    //         return response()->json(['error' => ['Email and Password are Wrong.']], 401);
    //     }
    // }



    // public function adminlogout(Request $request)
    // {
    //     $token=$request->user()->token();
    //     $token->revoke();
    //     return response()->json([
    //         'message' => 'Successfully logged out'
    //     ]);
    // }



    public function show($id)
    {
        $user= User::find($id);
        if($user){
            return $this->apiResponse(new UserResource($user) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the user not found' ,404);
    }




    public function show_information($id)
    {
        $user= User::find($id);
        if($user){
            return $this->apiResponse(new UserResource($user) , 'ok' ,200);
        }
        return $this->apiResponse(null ,'the user not found' ,404);
    }



    // public function update_informations_user(Request $request , $id)
    // {      if( $id==auth()->id()){
    //     $Validator=Validator::make($request->all(),[
    //         'first_name'=> ['nullable', 'string','min:3' ,'max:255'],
    //         'last_name'=> ['nullable', 'string','min:3' ,'max:255'],
    //         'phone_number'=>['nullable','min:10','max:10'],
    //         'email' => [ 'string', 'email', 'max:255' ,'unique:users',],
    //     ]);
    //     if($Validator->fails()) {
    //         return response()->json(['status' => 400 ,'message' => $Validator->errors()->messages() , 'data'=>null], Response::HTTP_BAD_REQUEST);
    //     }
    //     $user = User::find($id);
    //     if (!$user) {
    //         return $this->apiResponse(null, 'the user not found ', 404);
    //     }
    //     $user->update($request->all());
    //     if ($user) {
    //         return $this->apiResponse(new UserResource($user), 'the user update', 201);

    //     }
    // }
    //     return $this->apiResponse(null, 'The user does not have permissions.', 201);
    // }




    // public function change_password(Request $request , $id){
    //      if( $id==auth()->id()){
    //     $Validator = Validator::make($request->all(), [

    //         'password' => ['nullable', 'string', 'min:8'],
    //         'new_password' => ['nullable', 'string', 'min:8'],
    //     ]);
    //     if ($Validator->fails()) {
    //         return response()->json(['status' => 400, 'message' => $Validator->errors()->messages(), 'data' => null], Response::HTTP_BAD_REQUEST);
    //     }

    //     if ($request->has('password')) {
    //         if (password_verify($request->password, $request->password)) {
    //             if ($request->has('new_password')) {
    //                 $new_password = Hash::make($request->input('new_password'));
    //                 $request->update([
    //                     'password' => $new_password
    //                 ]);
    //             }
    //         }
    //     }
    //     }
    //     return $this->apiResponse(null, 'The password update.', 201);
    // }











////////employee
public function employeeLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        if(auth()->guard('employee')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'employee']);
            $employee = Employee::select('employees.*')->find(auth()->guard('employee')->user()->id);
            $success =  $employee;
            $success['token'] =  $employee->createToken('MyApp',['employee'])->accessToken;

            return response()->json($success, 200);
        }else{
            return response()->json(['error' => ['Email and Password are Wrong.']], 401);
        }
    }



     public function employeelogout(Request $request)
    {
        Auth::guard('employee-api')->user()->token()->revoke();
        // $token=$request->user()->token();
        // $token->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }











    ///doctor
    public function registerDoctor(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'NationalNumber' => ['required', 'min:10', 'max:14', 'regex:/^[0-9]+$/', 'exists:doctors'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->NationalNumber.',NationalNumber'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 401);
        }

        $national = $request->NationalNumber;
        $doctor = Doctor::where('NationalNumber', $national)->first();

        if (!$doctor) {
            return $this->apiResponse(null, 'Sorry, you do not have an account in this system', 404);
        }

        $doctor->email = $request->input('email');
        $doctor->password = Hash::make($request->input('password'));
        $doctor->save();

        if ($tokenResult = $doctor->createToken('Personal Access Token')) {
            $data["message"] = 'User successfully registered';
            $data["user_type"] = 'doctor';
            $data["doctor"] = $doctor;
            $data["token_type"] = 'Bearer';
            $data["access_token"] = $tokenResult->accessToken;

            return response()->json($data, Response::HTTP_OK);
        }

        return response()->json(['error' => ['Email and Password are wrong.']], 401);
    }




    public function LoginDoctor(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        if(auth()->guard('doctor')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'doctor']);
            $doctor = Doctor::select('doctors.*')->find(auth()->guard('doctor')->user()->id);
            $success =  $doctor;
            $success["user_type"] = 'doctor ';
            $success['token'] =  $doctor->createToken('MyApp',['doctor'])->accessToken;

            return response()->json($success, 200);
        }else{
            return response()->json(['error' => ['Email and Password are Wrong.']], 401);
        }
    }




    public function logoutDoctor(Request $request)
    {
        Auth::guard('doctor-api')->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
////to show his info for himself
        public function doctorInfo()
    {
        $doctor = auth()->user();

        return response()->json(['doctor' =>$doctor], 200);
    }




}

