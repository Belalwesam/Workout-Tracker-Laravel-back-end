<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\WorkoutController;
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

#public endpoints

//in the Auth Controller
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('user.register');
    Route::post('/login', 'login')->name('user.login');
});


//list all the workouts
Route::get('/workouts' , [WorkoutController::class , 'index'])->name('workout.index');
//showing an existing workout
Route::get('/workout/{workout}' , [WorkoutController::class , 'show'])->name('workout.show');


#protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    //logout end point
    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

    //workout related endpoints
    Route::controller(WorkoutController::class)->group(function() {
        //store a new workout
        Route::post('/store' , 'store')->name('workout.store');
        //delete an existing workout
        Route::delete('/workout/{workout}' , 'destroy')->name('workout.destroy');
        //editing an existing workout
        Route::patch('/workout/{workout}/edit' , 'edit')->name('workout.edit');
        //deleting an existing exercise
        Route::delete('/exercise/{exercise}' , 'destroyExercise')->name('exercise.destroy');
    });
});
