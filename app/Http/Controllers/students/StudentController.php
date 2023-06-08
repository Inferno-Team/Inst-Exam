<?php

namespace App\Http\Controllers\students;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\student\RequestNewMarksRevelRequest;
use App\Models\MarkRevelRequest;
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

    public function requestNewMarksRevel(RequestNewMarksRevelRequest $request)
    {
        $student = Student::where('user_id', Auth::user()->id)->with("year")->first();
        $mark_request = MarkRevelRequest::create([
            "date_financial_receipt" => $request->date_financial_receipt,
            "no_financial_receipt" => $request->no_financial_receipt,
            "student_id" => $student->id,
            "section_year_id" => $student->year->section_year_id,
        ]);
        return LocalResponse::returnMessage("تمت إضافة الطلب بنجاح");
    }
}
