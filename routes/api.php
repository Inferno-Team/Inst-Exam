<?php

use Illuminate\Http\Request;
use App\Http\Traits\LocalResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ModeratorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('error403', function (Request $request) {
    return response()->json([
        'msg' => 'invlied token'
    ]);
})->name('login');
Route::get('permission_error', fn () => LocalResponse::returnMessage('لا تملك صلاحية الدخول على هذا الرابط'))->name('permission_error');
Route::post('login', [UserController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {

    Route::group(['middleware' => ['is_admin']], function () {
        Route::post('/set_dates', [DateController::class, 'setDates']);
        Route::get('/dates', [DateController::class, 'getDates']);
        Route::get('/get-moderators/{section_id}', [ModeratorController::class, 'getAllModerators']);
        Route::post('/add-moderator', [ModeratorController::class, 'addModerator']);
        Route::post('/edit-moderator', [ModeratorController::class, 'editModerator']);
        Route::post('/remove-moderator', [ModeratorController::class, 'removeModerator']);
        Route::get('/get-years/{id}', [YearController::class, 'getYears']);
        Route::get('/get-sections', [SectionController::class, 'getAllSectionWithYears']);
        Route::get('/get_all_students/{section}/{year}', [StudentController::class, 'getAllStudent']);
        Route::get('/sections', [SectionController::class, 'getAllSections']);
        Route::post('/add-section', [SectionController::class, 'addSection']);
        Route::post('/change-student-status', [StudentController::class, 'changeStudentsStatus']);
    });
    Route::group(['middleware' => ['is_moderator']], function () {
        Route::get('/get-my-section-student', [\App\Http\Controllers\moderator\SectionController::class, 'getMySectionStudents']);
        Route::post('/add-new-student', [ModeratorController::class, 'addNewStudent']);
        Route::post('/add_course', [ModeratorController::class, 'addNewCourse']);
        Route::get('/my_courses', [ModeratorController::class, 'myCourses']);
        Route::post('/save-student-mark1', [ModeratorController::class, 'saveStudentMark1']);
        Route::post('/save-student-mark2', [ModeratorController::class, 'saveStudentMark2']);
        Route::post('/get-students-mark1', [ModeratorController::class, 'getStudentMark1']);
        Route::post('moderator', [ModeratorController::class, 'moderatorAccount']);
        Route::get("/get-all-requests", [ModeratorController::class, 'getAllRequests']);
        Route::get("/student-mark-report-data/{id}", [ModeratorController::class, 'studentMarkReportData']);
        Route::get('/top-ten', [ModeratorController::class,'getTopTen']);
    });
    Route::group(['middleware' => ['is_student']], function () {
        Route::get('get-my-courses', [\App\Http\Controllers\students\StudentController::class, 'getMyCourses']);
        Route::post('request-new-marks-revel', [\App\Http\Controllers\students\StudentController::class, 'requestNewMarksRevel']);
    });
});
