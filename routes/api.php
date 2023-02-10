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

Route::get('subjects/count', [\App\Http\Controllers\SubjectController::class, 'count']);
Route::get('groups/count', [\App\Http\Controllers\GroupController::class, 'count']);
Route::apiResources([
    'subjects' => \App\Http\Controllers\SubjectController::class,
    'teachers' => \App\Http\Controllers\TeacherController::class,
    'groups' => \App\Http\Controllers\GroupController::class
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
