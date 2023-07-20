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

    public function index(Request $request, $id)
    {
        $complaint = Complaint::find($id);
        $comments = $complaint->comments;
        return response()->json($comments);
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'value' => ['required', 'string', 'min:1', 'max:400']
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $complaint = Complaint::find($id);
        if (!$complaint) {
            return $this->apiResponse(null, 'this complaint not found', 404);
        }
        $comment = $complaint->comments()->create([
            'value' => $request->value,
            'complaint_id' => $id,
            'user_id' => Auth::id(),
        ]);
        return response()->json($comment);
    }


 // update one comment of one product
    public function update(Request $request, $id, $id2)
    {
        $validator = Validator::make($request->all(), [
            'value' => ['required', 'string', 'min:1', 'max:400']
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $complaint = Complaint::find($id);
        if (!$complaint) {
            return $this->apiResponse(null, 'this complaint not found', 404);
        }
        $comment = Comment::find($id2);
        $comment->update([
            'value' => $request->value,
            'complaint_id' => $id,
            'user_id' => Auth::id(),
        ]);
       
        return $this->apiResponse($comment, 'updated successfully', 201);
    }



 //  delete one comment
    public function destroy($id, $id2)
    {
        $complaint = Complaint::find($id);
        if (!$complaint) {
            return $this->apiResponse(null, 'this complaint not found', 404);
        }
        $comment = Comment::find($id2);
        if (!$comment) {
            return $this->apiResponse(null, 'This Comment not found', 404);
        }
        $comment->delete($id2);
        if ($comment) {
            return $this->apiResponse(null, 'This Comment deleted', 200);
        }
    }
}