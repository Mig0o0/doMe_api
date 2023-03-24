<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\TaskGoalController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/404', function(){
    return "Not Found";
})->name("err");

Route::get("tasks/{task}/tasks", [TasksController::class, 'index']);
Route::post("tasks/{task}/tasks", [TasksController::class, 'store']);
Route::post('tasks/{task}/complete', [TasksController::class, 'completeTask']);

Route::apiResource('goals.tasks', TaskGoalController::class)->shallow();
Route::apiResource('tasks', TasksController::class)->only(["update", 'destroy', 'show']);
Route::apiResource("goal", GoalsController::class)->missing(function(Request $request){
    return Redirect::route("err");
});
