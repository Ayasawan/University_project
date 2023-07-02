<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $table = "marks";

    protected $fillable = [
      'SubjectName','year','Specialization','PDF','Employee_id'];



    protected $primaryKey = "id";

    public $timestamps=true ;


     
    public function employee(){
        return $this->belongsTo(Employee::class,'Employee_id');
    }
}
