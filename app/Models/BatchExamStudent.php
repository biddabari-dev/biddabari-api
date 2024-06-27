<?php

namespace App\Models;

use App\Models\Backend\UserManagement\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchExamStudent extends Model
{
    use HasFactory;


    protected $table = 'batch_exam_student';

    public function students()
    {
        return $this->hasMany(Student::class, 'id', 'student_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }
}
