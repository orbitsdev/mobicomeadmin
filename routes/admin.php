<?php

use App\Livewire\Students\ListStudents;
use App\Livewire\Teachers\ListTeachers;
use App\Livewire\Teachers\ManageSections;
use App\Livewire\Users\ListUsers;
use App\Livewire\Users\UserDetails;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get("list-users", ListUsers::class )->name('list-users'); 
    Route::get("list-teachers", ListTeachers::class )->name('list-teachers'); 
    Route::get("manage-teacher-sections/{record}", ManageSections::class )->name('manage-teacher-sections'); 
    Route::get("list-students", ListStudents::class )->name('list-students'); 
});
// Route::get("users-details{record}/", UserDetails::class )->name('users-details'); 