<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;




class Doctor extends Authenticatable
{
    use HasFactory,HasApiTokens;

    protected $table = "doctors";

    protected $fillable = [
      'first_name','last_name','gender','info','working_time','NationalNumber','email','password'];



    protected $primaryKey = "id";

    public $timestamps=true ;


    public function subjects()
    {
        return $this->hasMany(Subject::class,'doctor_id');
    }


//check if the  doctor has this subject or not
    //     public function doctorHasSubject(Doctor $doctor, $subject_id)
    // {
    //     return $doctor->subjects()->where('id', $subject_id)->exists();
    // }
    public function doctorHasSubject($subject_id)
{
    foreach ($this->subjects as $subject) {
        if ($subject->id == $subject_id) {
            return true;
        }
    }

    return false;
}

}
