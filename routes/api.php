<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\Exercisecontroller;
use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\SectionController;
use App\Models\User;
use App\Models\Section;
use App\Models\Student;
use App\Models\Excercise;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserCollection;
use App\Http\Resources\SectionResource;
use App\Http\Resources\TakedExamResource;
use App\Http\Resources\UserAppResource;
use App\Models\EnrolledSection;
use Illuminate\Validation\ValidationException;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // return $request->user();

    return response()->apiResponse(['data' => new UserResource($request->user())]);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::post('/user-details', [ApiAuthController::class, 'userDetails'])->name('app.user-details');
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('app.logout');
    Route::post('/exercise/take', [ExercisesController::class,'take'])->name('take-exercise');
    Route::post('upload-profile-image', [ApiAuthController::class,'uploadProfileImage']);


});


Route::post('/login', [ApiAuthController::class, 'login'])->name('app.login');
Route::post('/register', [ApiAuthController::class, 'register'])->name('app.register');
Route::post('/take/exercise', [Exercisecontroller::class, 'takeExercises'])->name('app.take-exercise');
Route::get('/sections', [SectionController::class, 'getSections'])->name('all-sections');
Route::get('/chapters', [ChapterController::class, 'getChapters'])->name('all-chapters');
Route::get('/chapter/lessons', [ChapterController::class, 'getChapterLessons'])->name('get-chapter-lessons');
Route::get('/exercises', [ExercisesController::class, 'getExercises'])->name('get-exercises');
Route::post('/exercises/questions', [ExercisesController::class, 'getQuestions'])->name('get-exercises-questions');
Route::get('/exercise/questions', [ExercisesController::class, 'getExerciseQuestions'])->name('get-exercise-question');

Route::get('/student-exercises', [ExercisesController::class, 'getStudentExercises'])->name('set-student-exercise');


Route::get('/view-score', [ExercisesController::class, 'viewScore'])->name('view-score');


Route::post('/add-feedback', [ExercisesController::class, 'addFeedBack'])->name('add-feedback');




