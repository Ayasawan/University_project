<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;


    protected $fillable = ['content'];

    public function comments(){
        return $this->hasMany( Comment::class,'complaint_id');
    }
}

//    protected $fillable = ['user_id', 'content'];

//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }

