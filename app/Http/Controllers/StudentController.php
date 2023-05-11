<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function getAllStudent($section, $year)
    {
        // $students = Student::with('year.sectionYearTerm.yearTerm', 'year.sectionYearTerm.section')->get();
        // $students->groupBy(function ($item) {
        // });
        $students = Student::whereHas('year', function ($student_year) use ($section, $year) {
            $student_year->whereHas('sectionYear', fn ($sectionYear) =>
            $sectionYear->where('section_id', $section)->where('year_id', $year));
        })->with('year.sectionYear','user')->get();
        return response()->json(['students' => $students], 200);
    }
}
