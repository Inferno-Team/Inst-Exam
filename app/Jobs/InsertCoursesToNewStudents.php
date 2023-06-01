<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\Dates;
use App\Models\SectionYear;
use App\Models\SectionYearTerm;
use App\Models\StudentCourse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertCoursesToNewStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $student_id;
    public $section_year;
    public function __construct(int $student_id, int $section_year)
    {
        $this->student_id = $student_id;
        $this->section_year = $section_year;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get all courses for this section year
        // first get section_year_term_id for both terms
        $sectionYear = SectionYear::find($this->section_year);
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
                'student_id' => $this->student_id,
                'course_id' => $course->id,
                'year' => $date == null ? null : $date->year,
            ]);
            $c += 1;
        }
        info("$c courses added to student with id : $this->student_id");
    }
}
