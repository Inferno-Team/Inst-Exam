<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class InsertStudentMark2Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public  $course_id;
    public $marks;
    public function __construct(int $course_id, array $marks)
    {
        $this->marks = $marks;
        $this->course_id = $course_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $univIds = [];
        $course = Course::find($this->course_id);
        // get all unvi ids from mark array
        foreach ($this->marks as $mark) {
            $univIds[] = ((object)$mark)->univ_id;
        }
        $sCount = 0;
        // get all students with this unvi ids
        $students = Student::whereIn('univ_id', $univIds)->get();
        foreach ($students as $student) {
            $sc = StudentCourse::where('student_id', $student->id)->where('course_id', $this->course_id)->first();
            $sc->mark2 = $this->get_student_mark($student->univ_id);
            $sc->status = ($sc->mark1 + $sc->mark2) >= 60 ? 'ناجح' : 'راسب';
            $sc->save();
            $sCount += 1;
        }
        info("$sCount students data for course $course->name has been update mark2");
    }
    private function get_student_mark(int $univ_id)
    {
        foreach ($this->marks as $mark) {
            if (((object)$mark)->univ_id == $univ_id)
                return ((object)$mark)->mark;
        }
        info("student with univ ID $univ_id mark not found in marks course : #$this->course_id #InsertStudentMark2Job");
        return 0;
    }
}
