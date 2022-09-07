<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'subject_description',
        'subject_picture',
        'status',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subjects', 'subject_id', 'student_id');
    }

    public function section(){
        return $this->belongsToMany(Section::class, 'section_subjects', 'subject_id', 'section_id');
    }
}
