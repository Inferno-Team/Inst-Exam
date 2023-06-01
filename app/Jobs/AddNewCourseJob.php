<?php

namespace App\Jobs;

use App\Models\Dates;
use App\Models\Student;
use App\Models\SectionYear;
use App\Models\StudentYear;
use App\Models\StudentCourse;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AddNewCourseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $course;
    protected $section_year_term;
    public function __construct($course, $section_year_term)
    {
        $this->course = $course->withoutRelations();
        $this->section_year_term = $section_year_term;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $studentsCount = 0;
        // get student with last year only.
        $section_year = SectionYear::where(
            'section_id',
            $this->section_year_term->section_id
        )->where('year_id', $this->section_year_term->yearTerm->year_id)->first();
        // $studentSectionYear = StudentYear::where('section_year_id', $section_year->id)->with('student')->get();
        $students = Student::whereHas('year', function ($year) use ($section_year) {
            $year->where('section_year_id', $section_year->id);
        })->get();
        $date = Dates::first();
        foreach ($students as $student) {
            $cs = StudentCourse::create([
                'student_id' => $student->id,
                'course_id' => $this->course->id,
                'year' => $date == null ? null : $date->year,

            ]);
            $studentsCount++;
        }
        info("Course : " . $this->course->name . " has been added to $studentsCount students.");
    }
}
