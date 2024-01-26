<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'teacher_name',
        'designation',
        'date_of_birth',
        'gender',
        'religion',
        'phone',
        'address',
        'date_of_joining',
        'image',
        'email',
    ];
}
