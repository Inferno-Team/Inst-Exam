<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;

class StudentController extends Controller
{
    public function getAllStudent($year)
    {
        $students = Student::with('year.sectionYearTerm.yearTerm', 'year.sectionYearTerm.section')->get();
        $students->groupBy(function ($item) {
        });
        return response()->json(['students' => $students], 200);
    }
}
