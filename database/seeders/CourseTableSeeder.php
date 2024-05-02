<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Course;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course1 = Course::create(
            [
                'name' => 'Physics Course',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae 
                numquam deserunt quisquam repellat libero asperiores earum nam nobis, culpa ratione quam perferendis esse, cupiditate neque quas!',
                'created_by' => '1',
                'updated_by' => '1'
            ]
        );

        $course2 = Course::create(
            [
                'name' => 'Maths Course',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit!',
                'created_by' => '1',
                'updated_by' => '1'
            ]
        );

        $course3 = Course::create(
            [
                'name' => 'ICT Course',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae!',
                'created_by' => '1',
                'updated_by' => '1'
            ]
        );
    }
}
