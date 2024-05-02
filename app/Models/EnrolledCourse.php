<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledCourse extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enrolled_courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'created_by',
        'updated_by'
    ];


    public function studentData()
	{
		return $this->hasOne('App\Models\User','id','student_id');
    }

    public function courseData()
	{
		return $this->hasOne('App\Models\Course','id','course_id');
    }
}