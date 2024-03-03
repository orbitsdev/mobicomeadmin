<?php

use App\Livewire\ManageChapter;
use App\Livewire\Users\ListUsers;
use App\Livewire\Users\UserDetails;
use Illuminate\Support\Facades\Route;
use App\Livewire\Chapters\ListLessons;
use App\Livewire\Chapters\ListChapters;
use App\Livewire\Students\ListStudents;
use App\Livewire\Teachers\ListTeachers;
use App\Livewire\Chapters\LessonDetails;
use App\Livewire\Chapters\ManageLessons;
use App\Livewire\Chapters\ChapterDetails;
use App\Livewire\Lessons\ListLessons as LessonsListLessons;
use App\Livewire\Teachers\ManageSections;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get("list-users", ListUsers::class )->name('list-users'); 
    Route::get("list-teachers", ListTeachers::class )->name('list-teachers'); 
    Route::get("manage-teacher-sections/{record}", ManageSections::class )->name('manage-teacher-sections'); 
    Route::get("list-students", ListStudents::class )->name('list-students'); 
    Route::get("list-chapters", ListChapters::class )->name('list-chapters'); 
    Route::get("view-chapter/{record}", ChapterDetails::class )->name('view-chapter'); 
    // Route::get("manage-chapter/{record}", ManageChapter::class )->name('manage-chapter'); 
    Route::get("manage-chapter/lessons/{record}", ListLessons::class )->name('manage-chapter-lessons'); 
    Route::get("manage-chapter/view/lesson/{record}", LessonDetails::class)->name('view-lesson-details'); 
    Route::get("list-lessons", LessonsListLessons::class)->name('list-lessons'); 
});
// Route::get("users-details{record}/", UserDetails::class )->name('users-details'); 