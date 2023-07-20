<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = "subjects";

    protected $fillable = [
      'subject_name','semester','year','specialization','doctor_id'];



    protected $primaryKey = "id";

    public $timestamps=true ;


    public function lectures()
    {
        return $this->hasMany(Lecture::class,'Employee_id');
    }


    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

}
