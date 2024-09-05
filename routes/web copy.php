<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Staffs;


Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

//     Route::get('/profile', function () {
//         return view('profile');
//     })->name('profile');


// });


Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
Route::get('/staffs', [Staffs::class, 'index'])->name('app-user-list');

// laravel example
Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
Route::resource('/user-list', UserManagement::class);
