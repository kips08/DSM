<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DrawRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::get('companies', [CompanyController::class, 'index'])->name(
            'companies.index'
        );
        Route::post('companies', [CompanyController::class, 'store'])->name(
            'companies.store'
        );
        Route::get('companies/create', [
            CompanyController::class,
            'create',
        ])->name('companies.create');
        Route::get('companies/{company}', [
            CompanyController::class,
            'show',
        ])->name('companies.show');
        Route::get('companies/{company}/edit', [
            CompanyController::class,
            'edit',
        ])->name('companies.edit');
        Route::put('companies/{company}', [
            CompanyController::class,
            'update',
        ])->name('companies.update');
        Route::delete('companies/{company}', [
            CompanyController::class,
            'destroy',
        ])->name('companies.destroy');

        Route::get('draw-requests', [
            DrawRequestController::class,
            'index',
        ])->name('draw-requests.index');
        Route::post('draw-requests', [
            DrawRequestController::class,
            'store',
        ])->name('draw-requests.store');
        Route::get('draw-requests/create', [
            DrawRequestController::class,
            'create',
        ])->name('draw-requests.create');
        Route::get('draw-requests/{drawRequest}', [
            DrawRequestController::class,
            'show',
        ])->name('draw-requests.show');
        Route::get('draw-requests/{drawRequest}/edit', [
            DrawRequestController::class,
            'edit',
        ])->name('draw-requests.edit');
        Route::put('draw-requests/{drawRequest}', [
            DrawRequestController::class,
            'update',
        ])->name('draw-requests.update');
        Route::delete('draw-requests/{drawRequest}', [
            DrawRequestController::class,
            'destroy',
        ])->name('draw-requests.destroy');
    });
