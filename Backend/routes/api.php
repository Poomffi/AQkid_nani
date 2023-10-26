<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//      $request->user()->info;
//      return $request->user();
//     return User::with('info')->get();
// });

// Route::middleware(['auth:sanctum','multirole:staff'])->get('/test', function (Request $request) {
//     return [ 'success' => true ];
// });


// Route::middleware(['auth:sanctum'])->post('/revoke', function (Request $request) {
//     $user = auth()->user();

//     // Revoke all of the user's tokens
//     $user->tokens->each->delete();
// });


// Route::post('/loginServer', [AuthController::class,'loginServer'])->name('login.server');
// Route::get('/setApiCookie', [AuthController::class,'setApiCookie'])->name('cookie.server');

// Route::post('/testFETCH', function () {
//     return ['success' => true];
// })->name('test.server');




Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);

});




Route::group([

    'middleware' => 'api',
    'prefix' => 'staff'

], function ($router) {

    // index
    
    Route::get('allCourses', [StaffController::class, 'getAllCourses']);
    Route::get('courses/{course}', [StaffController::class, 'getCourse']);
    Route::get('allTimeslots', [StaffController::class, 'allTimeslots']);
    Route::get('timeslots/{timeslot}', [StaffController::class, 'getTimeslot']);
    Route::get('timeslotStudent/{timeslot}',[StaffController::class, 'getTimeslotStudents']);
    Route::post('addStudent/{timeslot}/{student}', [StaffController::class, 'addStudentAttendance']);
    Route::post('removeStudent/{timeslot}/{student}', [StaffController::class, 'removeStudentAttendance']);
    Route::post('createTimeslot/{course}', [StaffController::class, 'createTimeslot']);
    Route::post('removeTimeslot/{timeslot}', [StaffController::class, 'removeTimeslot']);

    // teacher
    Route::get('allTeachers', [StaffController::class, 'allTeachers']);
    Route::get('teachers/{user}', [StaffController::class, 'getTeacher']);
    Route::post('register', [StaffController::class, 'createTeacher']);
    Route::post('searchTeacher', [StaffController::class, 'searchTeacher']);

    // student
    Route::post('filterStudents', [StaffController::class, 'filterStudent']);
    Route::get('students/{user}', [StaffController::class, 'getStudent']);
    Route::post('searchStudent', [StaffController::class, 'searchStudent']);
   
    // enrollment
    Route::get('allEnrollments', [StaffController::class, 'allEnrollmentRequests']);
    Route::get('allEnrollmentHistorys', [StaffController::class, 'enrollmentNotPending']);
    Route::get('enrolls/{enrollment}', [StaffController::class, 'enrollmentRequestReview']);
    Route::post('acceptEnroll/{enrollment}', [StaffController::class,'acceptEnrollment']);
    Route::post('rejectEnroll/{enrollment}', [StaffController::class,'rejectEnrollment']);
    Route::get('historyEnrollment', [StaffController::class, 'enrollmentNotPending']);

    // refund
    Route::get('allUserRequests', [StaffController::class, 'allUserRequests']);
    Route::get('allUserRequestHistories', [StaffController::class, 'allUserRequestHistories']);
    Route::post('acceptUserRequest/{userRequest}', [StaffController::class,'acceptRequest']);
    Route::post('rejectUserRequest/{userRequest}', [StaffController::class,'rejectRequest']);
    Route::get('getUserRequest/{userRequest}',[StaffController::class, 'userRequestReview']);
  
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'teacher'

], function ($router) {

    Route::get('getEvent/{teacher}', [TeacherController::class, 'getEvent']);
    Route::get('getTimeslot/{timeslot}', [TeacherController::class, 'getTimeslot']);
    Route::get('getStudentAttend/{timeslot}', [TeacherController::class, 'getStudentAttends']);
    Route::post('attendStudent/{timeslot}/{student}', [TeacherController::class, 'studentAttend']);
    Route::post('absentStudent/{timeslot}/{student}', [TeacherController::class, 'studentAbsent']);
   
    
});


Route::group([
    
    'middleware' => 'api',
    'prefix' => 'student'
    
], function ($router) {
    
    Route::get('getClasses', [StudentController::class, 'getAllClasses']);
    Route::get('getAllCourses', [StudentController::class, 'getAllCourse']);
    Route::get('showCourse/{course}', [StudentController::class, 'showCourse']);
    Route::post('enrollCourse/{course}/{user}', [StudentController::class, 'enrollCourse']);
    
    
    Route::get('profile/{user}', [StudentController::class, 'profile']);
    Route::post('editprofile/{user}', [StudentController::class, 'updateProfile']);
    Route::post('editpassword/{user}', [StudentController::class, 'updatePassword']);
    Route::post('editimage/{user}', [StudentController::class, 'updateImage']);    

});


