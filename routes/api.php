<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProjectsController;

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

// /signup/{role} can work just feel like following this route...
Route::controller(AuthController::class)->group(function () {
    Route::post('/signup/{role}', 'create_user')->name('signup'); // https://snapnet.local/api/signup/Admin
    Route::post('/login', 'login')->name('login'); // https://snapnet.local/api/login
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('employee')->controller(EmployeeController::class)->group(function () {
        
        Route::post('/', 'store')->name('employee.store'); // https://snapnet.local/api/employee
        Route::get('/', 'index')->name('employee.index'); //https://snapnet.local/api/employee
        Route::get('/{id}', 'show')->name('employee.show'); //https://snapnet.local/api/employee/1
        Route::put('/{id}', 'update')->name('employee.update'); //https://snapnet.local/api/employee/1
        Route::delete('/{id}', 'destroy')->name('employee.destroy'); //https://snapnet.local/api/employee/1
    });

    Route::prefix('project')->controller(ProjectsController::class)->group(function () {
        Route::post('/', 'store')->name('project.store'); // https://snapnet.local/api/project
        Route::get('/', 'index')->name('project.index'); //https://snapnet.local/api/project
        Route::get('/{id}', 'show')->name('project.show'); //https://snapnet.local/api/project/1
        Route::put('/{id}', 'update')->name('project.update'); //https://snapnet.local/api/project/1
        Route::delete('/{id}', 'destroy')->name('project.destroy'); //https://snapnet.local/api/project/1

        Route::post('/{projectId}/assign-employee', 'addEmployeeToProject')->name('project.assign-employee'); // https://snapnet.local/api/project/1/assign-employee
        Route::post('/summary', 'getSummary')->name('project.assign-employee'); // https://snapnet.local/api/project/summary
    });

    Route::middleware('role:Admin')->controller(RoleController::class)->group(function () {
        Route::post('/user/{id}/assign-role', 'assignRole')->name('user.assign-role'); // https://snapnet.local/api/user/1/assign-role
        Route::post('/user/{id}/remove-role', 'removeRole')->name('user.remove-role'); // https://snapnet.local/api/user/1/remove-role
    });

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
