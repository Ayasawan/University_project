<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Lecture extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = "lectures";

    protected $fillable = [
      'lecture_name','pdf','type','subject_id'];



    protected $primaryKey = "id";

    public $timestamps=true ;

    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
    }


}
