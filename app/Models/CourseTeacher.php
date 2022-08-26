<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseTeacher extends Pivot
{
    use HasFactory;

    public function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}
