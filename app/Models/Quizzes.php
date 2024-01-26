<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizzes extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = [
        'quizz_title',
        'quizz_slug',
        'quizz_des',
        'instruction',
        'q_flow',
        'teacher_id',
        'duration',
    ];
}
