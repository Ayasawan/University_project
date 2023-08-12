<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    // show all likes
    public function index(Request $request ,$id)
    {      $complaint = Complaint::find($id);
        $likes = $complaint->likes()->get();
        return response()->json($likes);
    }

    public function store(Request $request ,$id)

    {
        $complaint = Complaint::find($id);
        if($complaint->likes()->where('user_id',Auth::id())->exists())
        {
            $complaint->likes()->where('user_id',Auth::id())->delete();
        }
        else
        {
            $complaint->likes()->create(['user_id'=>Auth::id()]);
        }

        return response()->json(null);
    }

  
    public function dislike($id)
    {
        $complaint = Complaint::find($id);
        if ($complaint) {
            $like = $complaint->likes()->where('user_id', Auth::id())->first();
            if ($like) {
                $like->delete(); // Remove the existing like (dislike the complaint)
            }
        }

        return response()->json(null);
    }


}
