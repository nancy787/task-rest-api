<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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
Route::prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'store']);  // Create a task
    Route::get('/', [TaskController::class, 'index']);   // List all tasks
    Route::put('/{task}', [TaskController::class, 'update']); // Update task status
    Route::delete('/{task}', [TaskController::class, 'destroy']); // Delete task
});
