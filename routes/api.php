<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('groups/count', [\App\Http\Controllers\GroupController::class, 'count']);
Route::get('lessons/count', [\App\Http\Controllers\LessonController::class, 'count']);
Route::get('lessons/timetable', [\App\Http\Controllers\LessonController::class, 'timetable']);
Route::get('rooms/count', [\App\Http\Controllers\RoomController::class, 'count']);
Route::get('subjects/count', [\App\Http\Controllers\SubjectController::class, 'count']);
Route::apiResources([
    'groups' => \App\Http\Controllers\GroupController::class,
    'lessons' => \App\Http\Controllers\LessonController::class,
    'rooms' => \App\Http\Controllers\RoomController::class,
    'subjects' => \App\Http\Controllers\SubjectController::class,
    'teachers' => \App\Http\Controllers\TeacherController::class
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
