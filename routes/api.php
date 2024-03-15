<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\Exercisecontroller;
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
    return $request->user();
});


Route::post('/login', [ApiAuthController::class, 'login'])->name('app.login');
Route::post('/register', [ApiAuthController::class, 'register'])->name('app.register');
Route::post('/take/exercise', [Exercisecontroller::class, 'takeExercises'])->name('app.take-exercise');
Route::get('/sections', [SectionController::class, 'getSections'])->name('all-sections');
Route::get('/chapters', [ChapterController::class, 'getChapters'])->name('all-chapters');
Route::get('/chapter/lessons', [ChapterController::class, 'getChapt`erLessons'])->name('get-chapter-lessons');
    