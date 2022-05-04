<?php

use App\Modules\Company\Controllers\CompanyController;
use App\Modules\Employee\Controllers\EmployeeController;
use App\Modules\User\Controllers\UserController;
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

Route::prefix('v1')->group(function (){
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);

    Route::middleware('auth:api')->group(function () {
        // user
        Route::prefix('user')->group(function (){
            Route::get('/', [UserController::class, 'getCurrentUser']);
        });

        // //companies
        Route::prefix('company')->group(function (){
            Route::get('/', [CompanyController::class, 'getAll']);
            Route::get('/{id}', [CompanyController::class, 'getCompany']);
            Route::post('/create', [CompanyController::class, 'create']);
            Route::put('/{id}', [CompanyController::class, 'update']);
            Route::delete('/{id}', [CompanyController::class, 'delete']);

        });

        // //employees
        Route::prefix('employee')->group(function (){
            Route::get('/', [EmployeeController::class, 'getAll']);
            Route::get('/{id}', [EmployeeController::class, 'getEmployee']);
            Route::get('/employee/{company_id}', [EmployeeController::class, 'getEmployeesToByCompanyId']);
            Route::post('/create', [EmployeeController::class, 'create']);
            Route::put('/{id}', [EmployeeController::class, 'update']);
            Route::delete('/{id}', [EmployeeController::class, 'delete']);
        });
    });
});
