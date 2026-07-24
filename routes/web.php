<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DigitalClassController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserManager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'home'])->name('index');
Route::get('/test', [IndexController::class, 'test'])->name('test');
Route::get('/register-as', [IndexController::class, 'user_type']);
Route::get('/get-class', [IndexController::class, 'get_class'])->name('get-class');
Route::get('/get-state-lga/{id}', [IndexController::class, 'get_state_lga'])->name('get-state-lga');
Route::get('/get-state', [IndexController::class, 'get_state'])->name('get-state');

Route::get('/verify', [HomeController::class, 'index_v'])->name('verify');
Route::middleware(['auth'])->group(function () {
    // Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::prefix('analytic')->group(function () {
        Route::get('/analytic', [HomeController::class, 'analytic']);
    });
    Route::get('/subject/manager', [CurriculumController::class, 'index'])->name('subject_index');

    Route::prefix('admin')->name('admin.')->group(function () {

        /*
        |--------------------------------------------------------------
        |   Curriculum Routes
        |--------------------------------------------------------------
        */
        Route::prefix('curriculum')->name('curriculum.')->group(function () {
            Route::get('/', [CurriculumController::class, 'index'])->name('index');

            /*
            |--------------------------------------------------------------
            |   Subject Routes
            |--------------------------------------------------------------
            */
            Route::post('/subjects', [CurriculumController::class, 'fetch_subject'])->name('subjects');
            // Route::get('/subjects-user', [CurriculumController::class, 'fetch_subject_user'])->name('fetch_subject_user');
            Route::get('/subjects/topics/{subject_id}', [CurriculumController::class, 'fetch_subject_topics'])->name('subjects.topics');
            Route::post('/subject/create', [CurriculumController::class, 'create_subject'])->name('subject.create');
            Route::post('/subject/edit', [CurriculumController::class, 'edit_subject'])->name('subject.edit');
            Route::post('/subject/delete', [CurriculumController::class, 'delete_subject'])->name('subject.delete');


            /*
            |--------------------------------------------------------------
            |   Topic Routes
            |--------------------------------------------------------------
            */
            Route::post('/topics', [CurriculumController::class, 'fetch_topic'])->name('topics');
            Route::post('/topics/create', [CurriculumController::class, 'create_topic'])->name('topics.create');
            Route::post('/topics/edit', [CurriculumController::class, 'update_topic'])->name('topics.edit');
            Route::post('/topics/delete', [CurriculumController::class, 'delete_topic'])->name('topics.delete');
        });
        Route::prefix('class')->name('class.')->group(function () {
            Route::get('/', [CurriculumController::class, 'class_index'])->name('index');

            /*
            |--------------------------------------------------------------
            |   class Routes
            |--------------------------------------------------------------
            */
            Route::get('/classes', [CurriculumController::class, 'fetch_class'])->name('classes');
            Route::post('/class/create', [CurriculumController::class, 'create_class'])->name('create');
            // Route::post('/subject/edit', [CurriculumController::class, 'edit_subject'])->name('subject.edit');
            // Route::post('/subject/delete', [CurriculumController::class, 'delete_subject'])->name('subject.delete');
        });
    });

    Route::prefix('client')->name('client.')->group(function () {
        /*
        |--------------------------------------------------------------
        |   Digital Learning Routes
        |--------------------------------------------------------------
        */
        Route::prefix('digital_class')->name('digital_class.')->group(function () {
            /*
            |--------------------------------------------------------------
            |   Live Class Routes
            |--------------------------------------------------------------
            */
            Route::prefix('live_class')->name('live_class.')->group(function () {
                Route::get('/', [DigitalClassController::class, 'liveClass'])->name('index');
                Route::post('/meeting_link/create', [DigitalClassController::class, 'saveMeetingLink'])->name('meeting_link.create');
                Route::post('/create', [DigitalClassController::class, 'saveLiveClassSchedule'])->name('create');
                Route::post('/fetch', [DigitalClassController::class, 'fetchLiveClass'])->name('fetch');
                Route::post('/edit', [DigitalClassController::class, 'editLiveClassSchedule'])->name('edit');
                Route::post('/update_meeting_link', [DigitalClassController::class, 'updateMeetingLink'])->name('update_meeting_link');
                Route::post('/update_elapsed', [DigitalClassController::class, 'updateElapsed'])->name('update_elapsed');
            });

            /*
            |--------------------------------------------------------------
            |   Recorded Videos Routes
            |--------------------------------------------------------------
            */
            Route::prefix('recorded_videos')->name('recorded_videos.')->group(function () {
                Route::get('/', [DigitalClassController::class, 'recordedVideos'])->name('index');
                Route::post('/fetch', [DigitalClassController::class, 'fetchRecordedVideos'])->name('fetch');
                Route::post('/create', [DigitalClassController::class, 'uploadRecordedVideos'])->name('create');
                Route::post('/edit', [DigitalClassController::class, 'editRecordedVideos'])->name('edit');
                Route::post('/change_status', [DigitalClassController::class, 'changeVideoStatus'])->name('change_status');
                Route::post('/delete', [DigitalClassController::class, 'deleteVideo'])->name('delete');
            });
        });
    });
    Route::prefix('assessment')->name('assessment.')->group(function () {
        Route::get('/', [QuizController::class, 'index'])->name('index');
        Route::get('/quiz_bank', [QuizController::class, 'quiz_index'])->name('quiz_bank');
        Route::get('/manage_assessment_questions/{quiz_id}', [QuizController::class, 'manage_quiz_questions'])->name('manage_assessment_questions');
        Route::get('fetch_live/{class_id}', [QuizController::class, 'fetchLive'])->name('fetch_live');
        Route::post('get_quiz_category', [QuizController::class, 'getQuizCategory'])->name('get_quiz_category');
        Route::post('/set_quiz_category', [QuizController::class, 'setQuizCategory'])->name('set_quiz_category');
        Route::post('/set_quiz', [QuizController::class, 'setQuiz'])->name('set_quiz');
        Route::post('/fetch_quiz_category', [QuizController::class, 'fetchQuizCategory'])->name('fetch_quiz_category');
        Route::post('/fetch_quiz', [QuizController::class, 'fetchQuiz'])->name('fetch_quiz');
        Route::post('/set_quiz_question', [QuizController::class, 'setQuizQuestion'])->name('set_quiz_question');
        Route::post('/fetch_quiz_questions', [QuizController::class, 'fetchQuizQuestions'])->name('fetch_quiz_questions');
        Route::post('/delete_question', [QuizController::class, 'deleteQuestion'])->name('delete_question');
        Route::post('/set_quiz_category_live', [QuizController::class, 'setQuizCategoryLive'])->name('set_quiz_category_live');
        Route::post('/set_quiz_live', [QuizController::class, 'setQuizLive'])->name('set_quiz_live');
        Route::get('/take_quiz_index', [QuizController::class, 'takeQuizIndex'])->name('take_quiz_index');
        Route::post('/fetch_live_quiz', [QuizController::class, 'fetchLiveQuizForStudent'])->name('fetch_live_quiz');
        Route::get('/start_quiz/{quiz_id}', [QuizController::class, 'startQuiz'])->name('start_quiz');
        Route::post('/fetch_to_start', [QuizController::class, 'fetchToStart'])->name('fetch_to_start');
        Route::post('/submit_quiz_student', [QuizController::class, 'submitQuiz'])->name('submit_quiz_student');
        Route::get('/get_quiz_result_student/{quiz_id}', [QuizController::class, 'getAnswer'])->name('get_quiz_result_student');
        Route::get('/get_quiz_result_teacher', [QuizController::class, 'getQuizQuestion'])->name('get_quiz_result_teacher');
    });
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/index', [AttendanceController::class, 'index'])->name('index');
    });
    // ---- User Manager ---
    Route::prefix('manage-user')->name('manage-user.')->group(function () {
        Route::get('/', [UserManager::class, 'index'])->name('index');
        Route::post('/all', [UserManager::class, 'All'])->name('all');
        Route::post('/update', [UserManager::class, 'Update'])->name('update');
        Route::post('/change_status', [UserManager::class, 'Status'])->name('status');
        Route::post('/delete', [UserManager::class, 'Remove'])->name('delete');
        // Route::post('/reset-admin-password', [UserManager::class, 'resetAdminPassword']);
        // Route::post('/change_role_admin', [UserManager::class, 'RemoveFromAdmin']);
    });
});

require __DIR__ . '/auth.php';
