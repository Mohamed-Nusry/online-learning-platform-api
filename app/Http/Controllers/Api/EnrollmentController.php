<?php

namespace App\Http\Controllers\Api;

use App\Models\EnrolledCourse;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\EnrolledRequest;
use Auth;

class EnrollmentController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $enrolledcourse = EnrolledCourse::with('studentData')->with('courseData')->get();
            return $this->success([
                'enrolledcourses' => $enrolledcourse,
            ], "Enrollment Courses Fetched Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function enrolled(EnrolledRequest $request)
    {
        try {
            $enrolledcourse = EnrolledCourse::where('student_id', $request->student_id)->with('studentData')->with('courseData')->get();
            return $this->success([
                'enrolledcourses' => $enrolledcourse,
            ], "Enrolled Courses Fetched Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function show($id)
    {
        try {
            $enrolledcourse_count = EnrolledCourse::where('id', $id)->count();

            if($enrolledcourse_count <= 0) {
                return $this->error([], "Enrollment Course Not Found...!", 200);
            }
            $enrolledcourse = EnrolledCourse::with('studentData')->with('courseData')->where('id', $id)->first();
            
            return $this->success([
                'enrolledcourse' => $enrolledcourse,
            ], "Enrollment Course Fetched Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function check(StoreEnrollmentRequest $request)
    {
        try {
            $request->validated($request->all());

            //check already enrolled
            $check_already_data = EnrolledCourse::where('student_id', $request->student_id)->where('course_id', $request->course_id)->count();

            if($check_already_data > 0) {
                return $this->success([
                    'data' => true,
                ], "Fetched Successfully...!");
            }

            return $this->success([
                'data' => false,
            ], "Fetched Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function store(StoreEnrollmentRequest $request)
    {
        try {
            $request->validated($request->all());

            //check already enrolled
            $check_already_data = EnrolledCourse::where('student_id', $request->student_id)->where('course_id', $request->course_id)->count();

            if($check_already_data > 0) {
                return $this->error('', 'Student already enrolled with this course', 200);
            }

            $enrolledcourse = new EnrolledCourse();

            $data = $request->only($enrolledcourse->getFillable());

            unset($data['created_by']);
            $data['created_by'] = Auth::user()->id;

            unset($data['updated_by']);
            $data['updated_by'] = Auth::user()->id;

            $enrolledcourse = EnrolledCourse::create($data);

            return $this->success([
                'enrolledcourse' => $enrolledcourse,
            ], "Enrollment Course Created Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function update($id, StoreEnrollmentRequest $request)
    {
        try {
            $request->validated($request->all());

            $enrolledcourse_count = EnrolledCourse::where('id', $id)->count();

            if($enrolledcourse_count <= 0) {
                return $this->error([], "Enrollment Course Not Found...!", 200);
            }

            //check already enrolled
            $check_already_data = EnrolledCourse::where('student_id', $request->student_id)->where('course_id', $request->course_id)->count();

            if($check_already_data > 0) {
                return $this->error('', 'Student already enrolled with this course', 200);
            }

            $enrolledcourse = EnrolledCourse::where('id', $id)->first();

            $data = $request->only($enrolledcourse->getFillable());

            unset($data['updated_by']);
            $data['updated_by'] = Auth::user()->id;

            $enrolledcourse->fill($data)->save();

            return $this->success([
                'enrolledcourse' => $enrolledcourse,
            ], "Enrollment Course Updated Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    
    public function delete($id)
    {
        try {
            $enrolledcourse_count = EnrolledCourse::where('id', $id)->count();

            if($enrolledcourse_count <= 0) {
                return $this->error([], "Enrollment Course Not Found...!", 200);
            }
            $enrolledcourse = EnrolledCourse::where('id', $id)->delete();
            
            return $this->success([
                'enrolledcourse' => null,
            ], "Enrollment Course Deleted Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

   
}