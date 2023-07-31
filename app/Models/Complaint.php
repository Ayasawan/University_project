<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $table = "complaints";

    protected $fillable = ['content','user_id','title',];

    protected $primaryKey = "id";
    public $timestamps = true ;

    public function comments(){
        return $this->hasMany( Comment::class,'complaint_id');
    }


    public function likes()
    {
        return $this->hasMany(Like::class,'complaint_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}


