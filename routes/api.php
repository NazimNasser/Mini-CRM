<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('user', [UserController::class, 'getAll']);
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
Route::delete('user/{id}', [UserController::class, 'delete']);

Route::group(['middleware' => ['jwt.verify']], function() {
    
    //Company Route
    
    Route::group(['prefix' => 'Companies'], function () {
        Route::get('/', [CompanyController::class, 'getAll']);
        Route::get('/{id}', [CompanyController::class, 'get']);
        Route::post('/', [CompanyController::class, 'create']);
        Route::post('/{id}', [CompanyController::class, 'update']);
        Route::delete('/{id}', [CompanyController::class, 'delete']);
    });
    
    
    //Employee Route
    
    Route::group(['prefix' => 'Employees'], function () {
        Route::get('/', [EmployeeController::class, 'getAll']);
        Route::get('/{id}', [EmployeeController::class, 'get']);
        Route::post('/', [EmployeeController::class, 'create']);
        Route::post('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'delete']);
    });
});