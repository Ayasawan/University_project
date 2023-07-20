<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyMarks extends Model
{
    use HasFactory;
    protected $table = "my_marks";
    protected $fillable = ['nameMark', 'markNum', 'year', 'semester','user_id'];

    
    protected $casts = [
        'semester' => 'string'
    ];

    protected $primaryKey = "id";

    public $timestamps=true ;


    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }

    public static function getAllowedSemesters()
    {
        return ['first', 'second', 'third'];
    }

    public static function getAllowedYears()
    {
        return ['first', 'second', 'third','fourth','fifth'];
    }
    
}
