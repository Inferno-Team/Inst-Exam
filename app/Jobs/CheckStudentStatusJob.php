<?php

namespace App\Jobs;

use App\Models\Dates;
use App\Models\Student;
use App\Models\StudentCourses;
use App\Models\StudentStatus;
use App\Models\StudentYear;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStudentStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = Dates::first();

        if (!isset($date))
            return;
        else {
            $current = $date->current;
            switch ($current) {
                case 'spring-holiday':
                case 'summer-holiday': {
                        $now = Carbon::now();
                        $year =  $now->year;
                        // check student courses [marks]
                        $sutdentsCourses = Student::with('courses', 'year')->get();
                        foreach ($sutdentsCourses as  $student) {
                            $student_last_year = false;
                            if ($student->section_year_id->year_id == 2)
                                $student_last_year = true;
                            $courses  = $student->courses;
                            $failedCourseCounter = 0;
                            foreach ($courses as $course) {
                                if ($course->status == 'راسب' || $course->status == 'اول مرة')
                                    $failedCourseCounter++;
                                if ($failedCourseCounter > 4)
                                    break;
                            }
                            $status = 'منقول';
                            $section_year_id = $student->section_year_id;
                            if ($failedCourseCounter <= 4) {
                                if ($student_last_year) {
                                    if ($failedCourseCounter == 0)
                                        $status = 'خريج';
                                    else
                                        $status = 'راسب';
                                } else {
                                    if ($failedCourseCounter == 0)
                                        $status = 'ناجح';
                                    $section_year_id++;
                                }
                            } else
                                $status = 'راسب';

                            StudentStatus::create([
                                'student_id' => $student->id,
                                'status' => $status,
                                'section_year_id' => $section_year_id,
                                'year_date' =>  $date->year,
                                'last_status' =>  $student->section_year_id != $section_year_id,
                            ]);
                            info("student : $student->univ_id  new status : $status");
                            if ($student->section_year_id != $section_year_id) {
                                $studentYear = StudentYear::where('student_id', $student->id)->first();
                                $studentYear->section_year_id = $section_year_id;
                                $studentYear->save();
                                $this->dispatch(new InsertCoursesToNewStudents($student->id, $section_year_id));
                            }
                        }
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
