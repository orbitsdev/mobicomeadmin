<?php

use App\Livewire\Teachers\ListTeachers;
use App\Livewire\Users\ListUsers;
use App\Livewire\Users\UserDetails;
use Illuminate\Support\Facades\Route;


Route::get("list-users", ListUsers::class )->name('list-users'); 
Route::get("list-teachers", ListTeachers::class )->name('list-teachers'); 
// Route::get("users-details{record}/", UserDetails::class )->name('users-details'); 