<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class StudentTest extends TestCase
{
    public function test_get_all_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/student');

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_store_student()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'Student',
            'username' => 'teststd',
            'email' => 'teststd@gmail.com',
            'password' => 'test@123',
            'password_confirmation' => 'test@123',
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/student/store', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => $data['username'],
            'email' => $data['email'],
        ]);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_get_one_data(): void
    {
        $user = User::factory()->create();

        $last_data = User::where('type','STUDENT')->latest()->first();

        $response = $this->actingAs($user)->get('/api/student/find/'.$last_data->id);

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_update_student()
    {
        $data = [
            'first_name' => 'Test1',
            'last_name' => 'Student1',
            'username' => 'teststd',
            'email' => 'teststd@gmail.com',
            'password' => 'test@123',
            'password_confirmation' => 'test@123',
        ];

        $last_data = User::where('type','STUDENT')->latest()->first();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/api/student/update/'.$last_data->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => $data['username'],
            'email' => $data['email'],
        ]);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);
    }

    public function test_delete_student()
    {

        $user = User::factory()->create();

        $last_data = User::where('type','STUDENT')->latest()->first();

        $response = $this->actingAs($user)->delete('/api/student/delete/'.$last_data->id);

        $response->assertStatus(200);

        //Delete created user for freeup records
        $last_user_data = User::where('type','ADMIN')->latest()->first();
        $delete_user = $this->actingAs($user)->delete('/api/user/delete/'.$last_user_data->id);

    }

    public function test_unauthorized_check(): void
    {

        $response = $this->get('/api/student');

        $response->assertStatus(401);
    }
}
