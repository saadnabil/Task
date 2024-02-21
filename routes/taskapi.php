<?php

use App\Http\Controllers\Api\DepartmentsController;
use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\Api\ManagerController;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routesp
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


Route::group(['prefix' => 'v1'], function(){


    Route::group(['prefix' => 'employee'],function(){
        Route::post('login', [EmployeesController::class , 'login']);
    });

    Route::group(['middleware' => 'auth:sanctum'],function(){

        Route::group(['prefix' => 'employee'],function(){
            Route::get('all', [EmployeesController::class , 'getAllEmployees']);
            Route::post('create', [EmployeesController::class , 'create']);
            Route::post('edit/{id}', [EmployeesController::class , 'edit']);
            Route::post('delete/{id}', [EmployeesController::class , 'delete']);
            Route::post('search', [EmployeesController::class , 'search']);
        });

        Route::group(['prefix' => 'department'],function(){
            Route::get('all', [DepartmentsController::class , 'getAllDepartments']);
            Route::post('create', [DepartmentsController::class , 'create']);
            Route::post('edit/{id}', [DepartmentsController::class , 'edit']);
            Route::post('delete/{id}', [DepartmentsController::class , 'delete']);
            Route::post('search', [DepartmentsController::class , 'search']);
        });

        Route::group(['prefix' => 'manager'],function(){
            Route::post('create', [ManagerController::class , 'create']);
            Route::post('search', [ManagerController::class , 'searchForEmployees']);
            Route::get('all/{employeeid}', [ManagerController::class , 'listEmployeeTasks']);
        });

    });

});

