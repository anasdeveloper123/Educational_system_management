<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTeacherStudent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course_teacher()
    {
        return $this->belongsTo(CourseTeacher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
