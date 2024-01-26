<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'student_name',
        'image',
        'father_name',
        'date_of_birth',
        'gender',
        'religion',
        'phone',
        'address',
        'register_no',
        'remarks',
        'email',
    ];
}
