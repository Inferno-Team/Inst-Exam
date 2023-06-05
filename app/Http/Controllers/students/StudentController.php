<?php

namespace App\Http\Controllers\students;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function getMyCourses()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->with('courses.course.sectionYearTerm')->first();
        $courses = $student->courses->map(fn ($sc) => (object)[
            "id" => $sc->course->id,
            "name" => $sc->course->name,
            "status" => $sc->status,
            "mark1" => $sc->mark1,
            "mark2" => $sc->mark2,
            "year" => $sc->year,
            "sectionYearTerm" => $sc->course->sectionYearTerm->format(),
        ]);

        return LocalResponse::returnData('courses', $courses);
    }
}
