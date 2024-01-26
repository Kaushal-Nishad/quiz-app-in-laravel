<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\QuizzesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


    Route::group(['middleware'=>'protectedPage'],function(){
        Route::get('admin/dashboard',[AdminController::class,'dashboard']);
        Route::get('admin/quizzes',[QuizzesController::class,'admin_quizzes']);
        Route::get('admin/questions',[QuizzesController::class,'admin_questions']);
        Route::resource('admin/teachers',TeacherController::class);
        Route::resource('admin/subjects',SubjectController::class);
        Route::resource('admin/students',StudentController::class);
        Route::any('admin/general-settings',[SettingsController::class,'general_settings']);
        Route::any('admin/profile-settings',[SettingsController::class,'profile_settings']);
        Route::any('admin/change-password',[SettingsController::class,'change_password']);
        Route::any('/',[AdminController::class,'index']);
        Route::get('admin/logout',[AdminController::class,'logout']);
    }); 

    Route::group(['middleware'=>'teacherprotectedPage'],function(){
        Route::any('teacher/login',[TeacherController::class,'loginTeacher']);
        Route::get('teacher/home',[TeacherController::class,'homePage']);
        Route::get('teacher/my-students',[TeacherController::class,'myStudents']);
        Route::get('teacher/student-report/{id}',[TeacherController::class,'studentReport']);
        Route::get('teacher/quizzes/leaderboard/{id}',[QuizzesController::class,'leaderboard']);
        Route::resource('teacher/quizzes',QuizzesController::class);
        Route::resource('teacher/questions',QuestionsController::class);
        Route::get('teacher/mailbox/sent',[MailboxController::class,'teacherSentMail']);
        Route::get('teacher/mailbox/sent/{id}',[MailboxController::class,'singleSentPage']);
        Route::any('teacher/mailbox/singlepage/{id}',[MailboxController::class,'singlePage']); 
        Route::resource('teacher/mailbox',MailboxController::class);
        //Route::post('mailbox/reply',[MailboxReplyController::class,'store']);
        Route::get('teacher/logout',[TeacherController::class,'Teacher_logout']);
        Route::any('teacher/profile',[TeacherController::class,'Teacher_profile']);
    }); 
    

    Route::group(['middleware'=>['studentprotectedPage']],function(){
        Route::any('student/student-login',[StudentController::class,'loginStudent']);
        Route::get('student/profile',[StudentController::class,'profile']);
        Route::get('student/logout',[StudentController::class,'logout']);
        Route::get('student/my-quizzes',[StudentController::class,'myQuizzes']);
        Route::any('student/quiz/leaderboard/{text}',[StudentController::class,'leaderboard']);
        Route::get('student/my-quiz-history',[StudentController::class,'quiz_history']);
        Route::get('student/q/instruction/{text}',[QuizzesController::class,'instruction']);
        Route::get('student/q/start/{text}',[QuizzesController::class,'create_quiz_session']);
        Route::any('student/quiz/{text}/{id}',[QuizzesController::class,'quiz_test']);
        Route::get('student/q/result/{text}',[QuizzesController::class,'test_result']);
        Route::get('student/q/summary/{id}',[QuizzesController::class,'test_summary']);
        Route::get('student/mailbox',[MailboxController::class,'studentMailbox']);
        Route::get('student/mailbox/create',[MailboxController::class,'studentcreate']);
        Route::post('student/mailbox/add',[MailboxController::class,'studentAddmail']);
        Route::get('student/mailbox/sent',[MailboxController::class,'studentSentMail']);
        Route::get('student/mailbox/sent/{id}',[MailboxController::class,'student_singleSentPage']);
        Route::any('student/mailbox/singlepage/{id}',[MailboxController::class,'studentSinglePage']);
        
    });
