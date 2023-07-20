<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Advertisement extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = "advertisements";

    protected $fillable = [
      'content','employee_id','doctor_id'];



    protected $primaryKey = "id";

    public $timestamps=true ;


    public function employee(){
        return $this->belongsTo(Employee::class,'Employee_id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
}
