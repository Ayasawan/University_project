<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RePractical extends Model
{
    use HasFactory;
    protected $table = 're_practical';

    protected $fillable = [
        'semester',
        'year',
        'subject_name',
       'user_id',
    ];

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
