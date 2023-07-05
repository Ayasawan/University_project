<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = "doctors";

    protected $fillable = [
      'first_name','last_name','gender','subject','working_time','email','password'];



    protected $primaryKey = "id";

    public $timestamps=true ;


    public function subjects()
    {
        return $this->hasMany(Subject::class,'doctor_id');
    }

    public function advertisements()
    {
        return $this->hasMany(dvertisement::class,'doctor_id');
    }

}
