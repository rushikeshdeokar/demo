<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "student";

    protected $fillable = [
        'student_name',
        'user_id',
        'class_teacher_id',
        'class',
        'admission_date',
        'yearly_fees',
    ];
}
