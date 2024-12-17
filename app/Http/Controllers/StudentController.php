<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseTeacher;
use App\Models\CourseTeacherStudent;
use App\Models\Student;
use App\Models\Teacher;

class StudentController extends Controller
{
    public function index()
    {
        $student = Studend::query()->get();
        $student_courses = [];
        foreach($students as $student){
            $student_courses[] = CourseTeacherStudent::query()
            ->with(['course_teacher_student', 'course_teacher_students.course_teacher','course_teacher_students.course_teacher.teacher','course_teacher_students.course_teacher.course'])
            ->find($student['id']); 
        }
        return response()->json([
            'status' => 1,
            'data' => $student_courses,
            'message' => "Student Indexed Successfully"
        ]);
    }

    public function store(Request $request): JsonResponse 
    {
        $request->validate([
            'student_name' => ['required', 'unique:students,name'],
            'student_course' => ['array', 'present'],
            'student_courses.*.teacher' => ['required'],
            'student_courses.*.course' => ['required'],
        ]);
         
        $student = Student::query()->create([
            'name' => $request['student_name'],
        ]);
        
        $student_courses = [];   
        foreach ($request['student_courses'] as $student_course){
            $teacher_name = $student_course['teacher'];
            $course_title = $student_course['course'];

            //create teacher if not exist
            $teacher = Teacher::query()->where('name', '=', $teacher_name)->first();
            if(is_null($teacher)){
                $teacher = Teacher::query()->create([
                    'name' => $teacher_name,
                ]);
            }

            //create course if not exist
            $course = Course::query()->where('title', '=', $course_title)->first();
            if(is_null($course)){
                $course = Course::query()->create([
                    'title' => $course_title,
                ]);
            }

            //link teacher to course if not exist
            $course_teacher = CourseTeacher::query()
                ->where('course_id', '=', $course['id'])
                ->where('teacher_id', '=', $teacher['id'])
                ->first();
            if(is_null($course_teacher)){
                $course_teacher = CourseTeacher::query()->create([
                    'course_id' => $course['id'],
                    'teacher_id' => $teacher['id'],
                ]);
            }

            //link student to teacher and course
            $student_course = CourseTeacherStudent::query()->create([
                'student_id' => $student['id'],
                'course_teacher_id' => $course_teacher['id']
            ]); 
            
            $student_courses[] = CourseTeacherStudent::query()
            ->select('id', 'student_id', 'course_teacher_id')
            ->with(['course_teacher:id,teacher_id,course_id', 'student:id,name', 'course_teacher.course:id,title', 'course_teacher.teacher:id,name'])
            ->find($student_course['id']);
        }
        return response()->json([
            'status' => 1,
            'data' => $student_courses,
            'message' => "Student Stored Successfully"
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_course' => ['array', 'present'],
            'student_courses.*.teacher' => ['required'],
            'student_courses.*.course' => ['required'],
        ]);
         
        $student = Student::query()->find('$id');
        
        $student_courses = [];   

        $student->course_teacher_students()->delete();

        foreach ($request['student_courses'] as $student_course){
            $teacher_name = $student_course['teacher'];
            $course_title = $student_course['course'];

            //create teacher if not exist
            $teacher = Teacher::query()->where('name', '=', $teacher_name)->first();
            if(is_null($teacher)){
                $teacher = Teacher::query()->create([
                    'name' => $teacher_name,
                ]);
            }

            //create course if not exist
            $course = Course::query()->where('title', '=', $course_title)->first();
            if(is_null($course)){
                $course = Course::query()->create([
                    'title' => $course_title,
                ]);
            }

            //link teacher to course if not exist
            $course_teacher = CourseTeacher::query()
                ->where('course_id', '=', $course['id'])
                ->where('teacher_id', '=', $teacher['id'])
                ->first();
            if(is_null($course_teacher)){
                $course_teacher = CourseTeacher::query()->create([
                    'course_id' => $course['id'],
                    'teacher_id' => $teacher['id'],
                ]);
            }

            //link student to teacher and course
            $student_course = CourseTeacherStudent::query()->create([
                'student_id' => $student['id'],
                'course_teacher_id' => $course_teacher['id']
            ]); 
            
            $student_courses[] = CourseTeacherStudent::query()
            ->select('id', 'student_id', 'course_teacher_id')
            ->with(['course_teacher:id,teacher_id,course_id', 'student:id,name', 'course_teacher.course:id,title', 'course_teacher.teacher:id,name'])
            ->find($student_course['id']);
        }
        return response()->json([
            'status' => 1,
            'data' => $student_courses,
            'message' => "Student Updated Successfully"
        ]);
    }
}