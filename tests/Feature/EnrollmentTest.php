<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\EnrolledCourse;

class EnrollmentTest extends TestCase
{
    public function test_get_all_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/enrollment');

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_store_enrollment()
    {
        $data = [
            'student_id' => 2,
            'course_id' => 1,
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/enrollment/store', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('enrolled_courses', [
            'student_id' => $data['student_id'],
            'course_id' => $data['course_id'],
        ]);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_get_one_data(): void
    {
        $user = User::factory()->create();

        $last_data = EnrolledCourse::latest()->first();

        $response = $this->actingAs($user)->get('/api/enrollment/find/'.$last_data->id);

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_update_enrollment()
    {
        $data = [
            'student_id' => 2,
            'course_id' => 2,
        ];

        $last_data = EnrolledCourse::latest()->first();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/api/enrollment/update/'.$last_data->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('enrolled_courses', [
            'student_id' => $data['student_id'],
            'course_id' => $data['course_id'],
        ]);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_delete_enrollment()
    {

        $user = User::factory()->create();

        $last_data = EnrolledCourse::latest()->first();

        $response = $this->actingAs($user)->delete('/api/enrollment/delete/'.$last_data->id);

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);

    }

    public function test_unauthorized_check(): void
    {

        $response = $this->get('/api/enrollment');

        $response->assertStatus(401);
    }
}
