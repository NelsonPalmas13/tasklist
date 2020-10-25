<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard/{concluded?}', [TasksController::class, 'index'])->name('dashboard');
    Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity');

    Route::get('/task', [TasksController::class, 'add']);
    Route::post('/task', [TasksController::class, 'create']);

    Route::get('/task/{task}', [TasksController::class, 'edit']);
    Route::post('/task/{task}', [TasksController::class, 'update']);
    Route::post('/task/{task}/conclude', [TasksController::class, 'conclude']);
});
