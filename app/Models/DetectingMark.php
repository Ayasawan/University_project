<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetectingMark extends Model
{
    use HasFactory;
    protected $fillable = ['FirstName','FatherName','LastName','BirthPlace','MatherName'];

}
