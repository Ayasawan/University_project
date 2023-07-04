<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = "schedules";

    protected $fillable = [
      'name','type','PDF','Employee_id'];



    protected $primaryKey = "id";

    public $timestamps=true ;


    public function employee(){
        return $this->belongsTo(Employee::class,'Employee_id');
    }
}
