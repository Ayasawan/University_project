<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Employee extends Authenticatable
{
    use HasFactory,HasApiTokens;

    protected $table = "employees";

    protected $fillable = [
      'FirstName','LastName','Gender','EmployeeWork','email','password'];



    protected $primaryKey = "id";

    public $timestamps=true ;


    public function marks()
    {
        return $this->hasMany(Mark::class,'Employee_id');
    }


    public function schedules()
    {
        return $this->hasMany(schedule::class,'Employee_id');
    }
}
