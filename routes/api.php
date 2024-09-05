<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::get('staff', [StaffController::class, 'tablex']);


Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');
