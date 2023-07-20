<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $fillable = [
        'value' ,
        'complaint_id',
        'user_id'
    ];
    protected $primaryKey = "id";
    public $timestamps = true ;



    public function complaint(){
        return $this->belongsTo(Complaint::class,'complaint_id');
    }

   

    public function user(){
        return $this->belongsTo(User::class,'user_id');}



}
