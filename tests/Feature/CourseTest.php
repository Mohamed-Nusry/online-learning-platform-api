<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;

class CourseTest extends TestCase
{
    public function test_get_all_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/course');

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_store_course()
    {
        $data = [
            'name' => 'History Course',
            'description' => 'Lorem Ipsum',
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/course/store', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('courses', [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_get_one_data(): void
    {
        $user = User::factory()->create();

        $last_data = Course::latest()->first();

        $response = $this->actingAs($user)->get('/api/course/find/'.$last_data->id);

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_update_course()
    {
        $data = [
            'name' => 'History Course',
            'description' => 'Lorem Ipsum dolar',
        ];

        $last_data = Course::latest()->first();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/api/course/update/'.$last_data->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('courses', [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_delete_course()
    {

        $user = User::factory()->create();

        $last_data = Course::latest()->first();

        $response = $this->actingAs($user)->delete('/api/course/delete/'.$last_data->id);

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);

    }

    public function test_unauthorized_check(): void
    {

        $response = $this->get('/api/course');

        $response->assertStatus(401);
    }
}
