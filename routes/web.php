<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::get('tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter');
});
Route::middleware('auth')->get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
