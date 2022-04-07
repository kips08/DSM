<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\DrawingController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DrawingLogController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\DrawRequestController;
use App\Http\Controllers\Api\CompanyUsersController;
use App\Http\Controllers\Api\DrawingDrawingLogsController;
use App\Http\Controllers\Api\CompanyDrawRequestsController;
use App\Http\Controllers\Api\DrawRequestDrawingsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::get('/companies', [CompanyController::class, 'index'])->name(
            'companies.index'
        );
        Route::post('/companies', [CompanyController::class, 'store'])->name(
            'companies.store'
        );
        Route::get('/companies/{company}', [
            CompanyController::class,
            'show',
        ])->name('companies.show');
        Route::put('/companies/{company}', [
            CompanyController::class,
            'update',
        ])->name('companies.update');
        Route::delete('/companies/{company}', [
            CompanyController::class,
            'destroy',
        ])->name('companies.destroy');

        // Company Requests
        Route::get('/companies/{company}/draw-requests', [
            CompanyDrawRequestsController::class,
            'index',
        ])->name('companies.draw-requests.index');
        Route::post('/companies/{company}/draw-requests', [
            CompanyDrawRequestsController::class,
            'store',
        ])->name('companies.draw-requests.store');

        // Company Users
        Route::get('/companies/{company}/users', [
            CompanyUsersController::class,
            'index',
        ])->name('companies.users.index');
        Route::post('/companies/{company}/users/{user}', [
            CompanyUsersController::class,
            'store',
        ])->name('companies.users.store');
        Route::delete('/companies/{company}/users/{user}', [
            CompanyUsersController::class,
            'destroy',
        ])->name('companies.users.destroy');

        Route::get('/draw-requests', [
            DrawRequestController::class,
            'index',
        ])->name('draw-requests.index');
        Route::post('/draw-requests', [
            DrawRequestController::class,
            'store',
        ])->name('draw-requests.store');
        Route::get('/draw-requests/{drawRequest}', [
            DrawRequestController::class,
            'show',
        ])->name('draw-requests.show');
        Route::put('/draw-requests/{drawRequest}', [
            DrawRequestController::class,
            'update',
        ])->name('draw-requests.update');
        Route::delete('/draw-requests/{drawRequest}', [
            DrawRequestController::class,
            'destroy',
        ])->name('draw-requests.destroy');

        // DrawRequest Drawings
        Route::get('/draw-requests/{drawRequest}/drawings', [
            DrawRequestDrawingsController::class,
            'index',
        ])->name('draw-requests.drawings.index');
        Route::post('/draw-requests/{drawRequest}/drawings', [
            DrawRequestDrawingsController::class,
            'store',
        ])->name('draw-requests.drawings.store');
    });
