<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\YearTerm;
use App\Models\SectionYear;
use App\Models\StudentYear;
use Illuminate\Http\Request;
use App\Jobs\AddNewCourseJob;
use App\Models\SectionYearTerm;
use App\Http\Traits\LocalResponse;
use Illuminate\Support\Facades\DB;
use App\Jobs\InsertStudentMark1Job;
use App\Jobs\InsertStudentMark2Job;
use App\Models\YearSectionModetator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\InsertCoursesToNewStudents;
use App\Http\Requests\AddModeratorRequest;
use App\Http\Requests\RemoveModeratorRequest;
use App\Http\Requests\moderator\AddNewStudentRequest;
use App\Http\Requests\moderators\AddNewCourseRequest;
use App\Http\Requests\moderator\SaveStudentMark2Request;
use App\Http\Requests\moderators\SaveStudentMarkRequest;

class ModeratorController extends Controller
{
    public function moderatorAccount()
    {
        $moderator = Auth::user();
        $moderator->moderatedSectionYear = $moderator->moderatedSectionYear;
        return LocalResponse::returnData('moderator', $moderator);
    }
    public function getAllModerators($section_id)
    {
        $moderators = User::where('type', 'مشرف')
            ->whereHas('moderatedSectionYear', function ($query) use ($section_id) {
                $query->where('section_id', $section_id);
            })
            ->get()->map->moderatorFormating();
        return LocalResponse::returnData('moderators', $moderators);
    }
    public function addModerator(AddModeratorRequest $request)
    {
        $moderator = User::create($request->values());
        $yearModerator = YearSectionModetator::create([
            'moderator_id' => $moderator->id,
            'year_id' => $request->year_id,
            'section_id' => $request->section_id,
        ]);
        $moderator->year = $yearModerator->yearFormation();
        return LocalResponse::returnData('moderator', $moderator, 'تم إنشاء المشرف بنجاح');
    }
    public function removeModerator(RemoveModeratorRequest $request)
    {
        $user = User::find($request->id); // select * from users where user.id = ?
        if ($user->type != 'مشرف') {
            return LocalResponse::returnMessage('هذا الرقم ليس لمشرف', 400);
        }
        $user->delete();
        return LocalResponse::returnMessage('تم حذف المشرف بنجاح');
    }
    public function editModerator(Request $request)
    {
        // info($request->all());
        // return;
        $user = User::find($request->id);
        if (isset($user)) {
            if ($user->type == 'مشرف') {
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone_number = $request->phone_number;
                if (isset($request->password))
                    $user->password = Hash::make($request->password);
                $moderatorYear = YearSectionModetator::where('moderator_id', $user->id)->first();
                $moderatorYear->delete();
                $user->save();
                YearSectionModetator::create([
                    'moderator_id' => $user->id,
                    'section_id' => $request->section_id,
                    'year_id' => $request->year_id,
                ]);
                $user = User::where('id', $request->id)->first()->moderatorFormating();
                return LocalResponse::returnData('moderator', $user, 'تم التعديل بنجاح', 200);
            }
            return LocalResponse::returnMessage('هذا المستخدم ليس بمشرف', 400);
        }
        return LocalResponse::returnMessage('لا يوجد مستخدم بهذا الرقم', 400);
    }
    public function addNewCourse(AddNewCourseRequest $request)
    {
        $user = Auth::user();
        $year = $user->moderatedSectionYear->year;
        $section = $user->moderatedSectionYear->section;
        $yearTerm = YearTerm::where('year_id', $year->id)->where('name', 'LIKE', $request->tirm_name)->first();
        if (!isset($yearTerm))
            return LocalResponse::returnMessage('there is no year term with this data.', 401);
        $section_year_term = SectionYearTerm::where('year_term_id', $yearTerm->id)->where('section_id', $section->id)->first();
        if (!isset($section_year_term))
            return LocalResponse::returnMessage('there is no section year term with this data.', 401);
        $course = Course::create([
            'name' => $request->name,
            'section_year_term_id' => $section_year_term->id,
        ]);
        // AddNewCourseJob::dispatch($course,$section_year_term);
        $this->dispatch(new AddNewCourseJob($course, $section_year_term));
        return LocalResponse::returnMessage('سوف يتم إضافة هذه المادة قريبا', 200);
    }
    public function myCourses()
    {
        $moderator = Auth::user();
        $year = $moderator->moderatedSectionYear->year;
        $section = $moderator->moderatedSectionYear->section;
        $yearTerms = YearTerm::where('year_id', $year->id)->get();
        $yearTermsIds = [];
        foreach ($yearTerms as $yt)
            $yearTermsIds[] = $yt->id;
        $section_year_terms = SectionYearTerm::whereIn('year_term_id', $yearTermsIds)->where('section_id', $section->id)->get();
        $ids = [];
        foreach ($section_year_terms as $syt)
            $ids[] = $syt->id;

        $courses = Course::whereIn('section_year_term_id', $ids)->with('students')->get()->map(function ($course) {
            return (object)[
                "id" => $course->id,
                "course_name" => $course->name,
                "all_students" => $course->students_count,
                "first_time" => $course->first_time_count,
                "passed" => $course->sucessed_count,
                "faild" => $course->failed_count,
                // check if this course have already mark1
                "mark1_ava" => count($course->students->filter(function ($student) {
                    return $student->this_year_ava_mark1;
                })) > 0,
                "mark2_ava" => count($course->students->filter(function ($student) {
                    return $student->this_year_ava_mark2;
                })) > 0,

            ];
        });
        return LocalResponse::returnData('courses', $courses);
    }
    public function saveStudentMark1(SaveStudentMarkRequest $request)
    {
        $this->dispatch(new InsertStudentMark1Job($request->course_id, $request->marks));
        return LocalResponse::returnMessage('سوف يتم إضافة هذه العلامات قريبا');
    }
    public function saveStudentMark2(SaveStudentMark2Request $request)
    {
        $this->dispatch(new InsertStudentMark2Job($request->course_id, $request->marks));
        return LocalResponse::returnMessage('سوف يتم إضافة هذه العلامات قريبا');
    }

    public function addNewStudent(AddNewStudentRequest $request)
    {
        try {
            DB::beginTransaction();
            $univ_id = $this->generate_univ_id();
            $user = User::create([
                'first_name' => $request->first_name,
                'password' => Hash::make($univ_id),
                'last_name' => $request->last_name,
                'type' => 'طالب'
            ]);
            $student = Student::create([
                'univ_id' => $univ_id,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'last_name' => $request->last_name,
                'user_id' => $user->id,
                'birth_place' => $request->birth_place,
                'gender' => $request->gender,
                'field_number' => $request->field_number,
                'recruitment_division' => $request->recruitment_division,
                'city' => $request->city,
                'address' => $request->address,
                'nationalty' => $request->nationalty
            ]);
            // section is this moderator section
            $moderator = Auth::user();
            $moderatedSectionYear = $moderator->moderatedSectionYear;
            $section_year = SectionYear::where('section_id', $moderatedSectionYear->section_id)
                ->where('year_id', $moderatedSectionYear->year_id)->first();
            StudentYear::create([
                'student_id' => $student->id,
                'section_year_id' => $section_year->id,
            ]);
            $this->dispatch(new InsertCoursesToNewStudents($student->id, $section_year->id));
            DB::commit();
            return LocalResponse::returnData(
                "student",
                $student,
                'تم انشاء الطالب بنجاح سوف يتم إضافة مواد السنة الاولى له بعد قليل'
            );
        } catch (Exception $e) {
            DB::rollBack();
            return LocalResponse::returnError($e->getMessage(), 400);
        }
    }
    private function generate_univ_id(): int
    {
        while (true) {
            $id = random_int(1000, 100_000);
            // check if this id in database
            $student = Student::where('id', $id)->first();
            if (!isset($student)) {
                return $id;
            }
        }
    }
}
