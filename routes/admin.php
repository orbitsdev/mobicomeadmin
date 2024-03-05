<?php

use App\Models\Excercise;
use App\Livewire\ManageChapter;
use App\Livewire\Users\ListUsers;
use App\Livewire\Users\UserDetails;
use App\Livewire\Lessons\EditLesson;
use Illuminate\Support\Facades\Route;
use App\Livewire\Chapters\EditChapter;
use App\Livewire\Chapters\ListLessons;
use App\Livewire\Lessons\CreateLesson;
use App\Livewire\Chapters\ListChapters;
use App\Livewire\Students\ListStudents;
use App\Livewire\Teachers\ListTeachers;
use App\Livewire\Chapters\CreateChapter;
use App\Livewire\Chapters\LessonDetails;
use App\Livewire\Chapters\ManageLessons;
use App\Livewire\Chapters\ChapterDetails;
use App\Livewire\Chapters\EditChapterLesson;
use App\Livewire\Exercises\EditExcercise;
use App\Livewire\Exercises\ListQuestions;
use App\Livewire\Teachers\ManageSections;
use App\Livewire\Exercises\ManageExercise;
use App\Livewire\Excercises\CreateExercise;
use App\Livewire\Excercises\ListExcercises;
use App\Livewire\Questions\QuestionDetails;
use App\Livewire\Excercises\ExerciseDetails;
use App\Livewire\Exercises\ManageTrueOrFalse;
use App\Livewire\Exercises\ManageFillInTheBlank;
use App\Livewire\Exercises\ManageMultipleChoice;
use App\Livewire\Lessons\ListLessons as LessonsListLessons;
use App\Livewire\Lessons\LessonDetails as LessonsLessonDetails;
use App\Livewire\Users\EditUser;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get("list-users", ListUsers::class )->name('list-users');
    Route::get("edit/profile/{record}", EditUser::class )->name('edit-profile');
    Route::get("list-teachers", ListTeachers::class )->name('list-teachers');
    Route::get("manage-teacher-sections/{record}", ManageSections::class )->name('manage-teacher-sections');
    Route::get("list-students", ListStudents::class )->name('list-students');
    Route::get("list-chapters", ListChapters::class )->name('list-chapters');
    Route::get("create-chapter", CreateChapter::class)->name('create-chapter');
    Route::get("edit-chapter/{record}", EditChapter::class)->name('edit-chapter');
    Route::get("view-chapter/{record}", ChapterDetails::class )->name('view-chapter');

    Route::get("chapter-lessons-list/{record}", ListLessons::class )->name('chapter-lessons-list');
    Route::get("chapter/{record}lesson/create/", CreateLesson::class )->name('chapter-create-lesson');
    Route::get("chapter/lesson/edit/{record}", EditChapterLesson::class )->name('chapter-edit-lesson');
    Route::get("chapter/view/lesson/{record}", LessonDetails::class)->name('chapter-view-lesson');

    Route::get("view/lesson/{record}", LessonDetails::class)->name('view-lesson');

    Route::get("lesson/edit/{record}", EditLesson::class )->name('edit-lesson');
    Route::get("list-lessons", LessonsListLessons::class)->name('list-lessons');
    Route::get("lessons/view/lesson/{record}", LessonsLessonDetails::class)->name('lessons-lessonn-details');


    Route::get("list-excercises", ListExcercises::class)->name('list-excercises');
    Route::get("excercise/create", CreateExercise::class)->name('create-exercise');
    Route::get("excercise/edit/{record}", EditExcercise::class)->name('edit-exercise');
    Route::get("excercise/multiple-choice/{record}", ManageMultipleChoice::class)->name('manage-multiple-choice');
    Route::get("excercise/true-or-false/{record}", ManageTrueOrFalse::class)->name('manage-true-or-flase');
    Route::get("excercise/fill-in-the-blank/{record}", ManageFillInTheBlank::class)->name('manage-fill-in-the-blank');
    Route::get("excercise/view/{record}",  ExerciseDetails::class)->name('view-exercise');

    Route::get("manage-excercise/questions/{record}", ListQuestions::class)->name('manage-excercise-questions');
    Route::get("manage-excercise/questions/{record}", ListQuestions::class)->name('manage-excercise-questions');
    Route::get("view-question/{record}", QuestionDetails::class)->name('view-question-details');
    // Route::get("view-excercise/{record}", ExerciseDetails::class)->name('view-excercise');
});
// Route::get("users-details{record}/", UserDetails::class )->name('users-details');
