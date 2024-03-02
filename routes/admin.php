<?php




use App\Livewire\Users\ListUsers;
use Illuminate\Support\Facades\Route;


Route::get("list-users", ListUsers::class )->name('list-users'); 