<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseTeacher;
use App\Models\Course;
class CourseTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::where('title', '=', 'English')->get();
        $id=1;
        if(count($courses)!=0){
            $id=$couses->first()['id'];
        }
        CourseTeacher::query()->create([
            'course_id' => $id,
            'teacher_id' => 2,
        ]);
        CourseTeacher::query()->create([
            'course_id' => 1,
            'teacher_id' => 2,
        ]);
        CourseTeacher::query()->create([
            'course_id' => 2,
            'teacher_id' => 3,
        ]);
        CourseTeacher::query()->create([
            'course_id' => 2,
            'teacher_id' => 4,
        ]);
        CourseTeacher::query()->create([
            'course_id' => 3,
            'teacher_id' => 2,
        ]);
        CourseTeacher::query()->create([
            'course_id' => 4,
            'teacher_id' => 3,
        ]);
    }
}
