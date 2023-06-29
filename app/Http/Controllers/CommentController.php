<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class CommentController extends Controller
{
    use ApiResponseTrait;
    public function index( )
    {
        $comments = CommentResource::collection(Comment::get());
        return response()->json($comments);
    }
        public function store(Request $request)
    {

                $input=$request->all();
        $request->validate([
            "value" => ['required', 'string','min:1', 'max:400'],
            "complaint_id"=>'required',
        ]);
        $comment = Comment::query()->create([
            'value' => $request->value,
            'complaint_id' =>$request->complaint_id,
        ]);
        return response()->json($comment);
    }

//    public function store(Request $request, Complaint $Complaint)
//    {
//        $request->validate([
//            "value" => ['required', 'string','min:1', 'max:400'],
//        ]);
//        $comment = $Complaint->comments()->create([
//            'value' => $request->value,
//
//        ]);
//        return response()->json($comment);
//    }
//    public function update(Request $request, $id ,$id_comment)
//    {
//        $validator=Validator::make($request->all(),[
//            'value'  => [ 'required' ,'string' ,'min:1' ]
//        ]);
//        if($validator->fails()) {
//            return $this->apiResponse(null ,$validator->errors(),400);}
//        $Complaint= Complaint ::find($id);
//        if(!$Complaint) {
//            return $this->apiResponse(null ,'the   Product not found ',404);
//        }
//        $comment=Comment::find($id_comment);
//        if(!$comment)
//        {
//            return $this->apiResponse(null ,'the  comment not found ',404);
//        }
//        $comment->update($request->all());
//        return $this->apiResponse(new CommentResource($comment) , 'the comment update',201);
//
//    }
//    public function destroy($id)
//    {
//        $comment = Comment::find($id);
//
//        if (!$comment) {
//            return $this->apiResponse(null, 'the comment not found ', 404);
//
//        }
//        $comment->delete($id);
//        if ($comment)
//            return $this->apiResponse(null, 'the comment delete ', 200);
//    }
}
