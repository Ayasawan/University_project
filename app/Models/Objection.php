<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;

    protected $table = "objections";
    protected $fillable = ['date', 'year', 'semester', 'subjectName','type','oldMark','user_id'];


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
