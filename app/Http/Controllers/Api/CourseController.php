<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use Auth;

class CourseController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $course = Course::all();
            return $this->success([
                'courses' => $course,
            ], "Courses Fetched Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function show($id)
    {
        try {
            $course_count = Course::where('id', $id)->count();

            if($course_count <= 0) {
                return $this->error([], "Course Not Found...!", 200);
            }
            $course = Course::where('id', $id)->first();
            
            return $this->success([
                'course' => $course,
            ], "Course Fetched Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function store(StoreCourseRequest $request)
    {
        try {
            $request->validated($request->all());

            $course = new Course();

            $data = $request->only($course->getFillable());

            unset($data['created_by']);
            $data['created_by'] = Auth::user()->id;

            unset($data['updated_by']);
            $data['updated_by'] = Auth::user()->id;

            $course = Course::create($data);
            return $this->success([
                'course' => $course,
            ], "Course Created Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function update($id, StoreCourseRequest $request)
    {
        try {
            $request->validated($request->all());

            $course_count = Course::where('id', $id)->count();

            if($course_count <= 0) {
                return $this->error([], "Course Not Found...!", 200);
            }
            $course = Course::where('id', $id)->first();

            $data = $request->only($course->getFillable());

            unset($data['updated_by']);
            $data['updated_by'] = Auth::user()->id;

            $course->fill($data)->save();

            return $this->success([
                'course' => $course,
            ], "Course Updated Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    
    public function delete($id)
    {
        try {
            $course_count = Course::where('id', $id)->count();

            if($course_count <= 0) {
                return $this->error([], "Course Not Found...!", 200);
            }
            $course = Course::where('id', $id)->delete();
            
            return $this->success([
                'course' => null,
            ], "Course Deleted Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

   
}