<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'FirstName' , 'LastName' , 'FatherName' ,'MotherName', 'Specialization','Year','Birthday',
        'BirthPlace','Gender' ,'Location','Phone', 'ExamNumber' ,'Average','NationalNumber', 'email' ,
        'password'
    ];
    public function MyMarks(){
        return $this->hasMany(MyMarks::class,'user_id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
