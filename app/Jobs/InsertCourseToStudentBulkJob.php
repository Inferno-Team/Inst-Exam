<?php

namespace App\Jobs;

use App\Models\Dates;
use App\Models\Course;
use App\Models\SectionYear;
use App\Models\StudentCourse;
use Illuminate\Bus\Queueable;
use App\Models\SectionYearTerm;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class InsertCourseToStudentBulkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $studentIds;
    public $section_year_id;
    public function __construct($studentIds, $section_year_id)
    {
        $this->section_year_id = $section_year_id;
        $this->studentIds = $studentIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->studentIds as $student_id) {
            // get all courses for this section year
            // first get section_year_term_id for both terms
            $sectionYear = SectionYear::find($this->section_year_id);
            $terms = SectionYearTerm::where('section_id', $sectionYear->section_id)
                ->whereHas('yearTerm', function ($yearTerm) use ($sectionYear) {
                    $yearTerm->where('year_id', $sectionYear->year_id);
                })->get();
            $ts = [];
            for ($i = 0; $i < count($terms); $i++) {
                // [1,2]
                $ts[] = $terms[$i]->id;
            }
            $courses = Course::whereIn('section_year_term_id', $ts)->get();
            $c = 0;
            $date = Dates::first();
            foreach ($courses as $course) {
                $cs = StudentCourse::create([
                    'student_id' => $student_id,
                    'course_id' => $course->id,
                    'year' => $date == null ? null : $date->year,
                ]);
                $c += 1;
            }
            info("$c courses added to student with id : $student_id");
        }
    }
}
