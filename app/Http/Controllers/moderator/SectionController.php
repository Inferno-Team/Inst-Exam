<?php

namespace App\Http\Controllers\moderator;

use App\Models\StudentYear;
use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;
use App\Http\Controllers\Controller;
use App\Models\YearSectionModetator;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function getMySectionStudents()
    {
        $moderator = Auth::user();
        $yearSection = YearSectionModetator::where('moderator_id', $moderator->id)->with('section', 'year')->first();
        $studentYear = StudentYear::whereHas('sectionYear', function ($sectionYear) use ($yearSection) {
            $sectionYear->where('section_id', $yearSection->section_id)->where('year_id', $yearSection->year_id);
        })->with('student')->get()->map(function ($s) {
            $student = $s->student;
            return (object)[
                'ت' => $student->id,
                'الاسم' => $student->user->first_name,
                'اسم الأب' => $student->father_name,
                'اسم الأم' => $student->mother_name,
                'الكنية' => $student->last_name,
                // 'phone_number' => $student->user->phone_number,
                // 'gender' => $student->gender,
            ];
        });
        return LocalResponse::returnData('section', [
            'name' => $yearSection->section->name,
            'years' => [
                [
                    'name' => $yearSection->year->name,
                    'students' => $studentYear
                ]
            ],
        ]);
    }
}
