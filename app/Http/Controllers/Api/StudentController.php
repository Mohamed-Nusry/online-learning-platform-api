<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Auth;

class StudentController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $student = User::where('type', 'STUDENT')->get();
            return $this->success([
                'students' => $student,
            ], "Students Fetched Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function show($id)
    {
        try {
            $student_count = User::where('id', $id)->count();

            if($student_count <= 0) {
                return $this->error([], "Student Not Found...!");
            }
            $student = User::where('id', $id)->first();
            
            return $this->success([
                'student' => $student,
            ], "Student Fetched Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $request->validated($request->all());

            $student = new User();

            $data = $request->only($student->getFillable());

            $student = User::create($data);
            return $this->success([
                'student' => $student,
            ], "Student Created Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    public function update($id, UpdateUserRequest $request)
    {
        try {
            $request->validated($request->all());

            $student_count = User::where('id', $id)->count();

            if($student_count <= 0) {
                return $this->error([], "Student Not Found...!");
            }
            $student = User::where('id', $id)->first();

            $data = $request->only($student->getFillable());

            $student->fill($data)->save();

            return $this->success([
                'student' => $student,
            ], "Student Updated Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

    
    public function delete($id)
    {
        try {
            $student_count = User::where('id', $id)->count();

            if($student_count <= 0) {
                return $this->error([], "Student Not Found...!");
            }
            $student = User::where('id', $id)->delete();
            
            return $this->success([
                'student' => null,
            ], "Student Deleted Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

   
}