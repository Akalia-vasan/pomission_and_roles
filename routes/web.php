<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserTableController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RoleTableController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\CompanyTableController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\EmployeeTableController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\VerificationController;
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

Route::get('/task', function () {
    return view('welcome');
});

Auth::routes(['logout' => false,
'verify' => true]);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'prefix' => 'auth',
    'as' => 'admin.auth.',
    'namespace' => 'Auth',
    'middleware' => 'auth',
], function () {
    // User Management
    Route::group(['namespace' => 'User'], function () {
        // For DataTables
        Route::post('user/get', [UserTableController::class, 'invoke'])->name('user.get');


        // User CRUD
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user', [UserController::class, 'store'])->name('user.store');
        Route::group(['prefix' => 'user/{user}'], function () {
            Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::patch('/edit', [UserController::class, 'update'])->name('user.update');
            Route::delete('/delete', [UserController::class, 'destroy'])->name('user.destroy');
            Route::get('/show', [UserController::class, 'show'])->name('user.show');

        });
    });

    Route::group(['namespace' => 'Role', 'prefix' => 'role'], function () {
        // For DataTables
        Route::post('/get', [RoleTableController::class, 'invoke'])->name('role.get');


        // Role CRUD
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/', [RoleController::class, 'store'])->name('role.store');
        Route::group(['prefix' => '{role}'], function () {
            Route::get('/edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::patch('/edit', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/delete', [RoleController::class, 'destory'])->name('role.destroy');
            Route::get('/show', [RoleController::class, 'show'])->name('role.show');

        });
    });

    Route::group(['namespace' => 'Company', 'prefix' => 'company'], function () {
        // For DataTables
        Route::post('/get', [CompanyTableController::class, 'invoke'])->name('company.get');


        // Company CRUD
        Route::get('/', [CompanyController::class, 'index'])->name('company.index');
        Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
        Route::post('/', [CompanyController::class, 'store'])->name('company.store');
        Route::group(['prefix' => '{company}'], function () {
            Route::get('/edit', [CompanyController::class, 'edit'])->name('company.edit');
            Route::patch('/edit', [CompanyController::class, 'update'])->name('company.update');
            Route::delete('/delete', [CompanyController::class, 'destroy'])->name('company.destroy');
            Route::get('/show', [CompanyController::class, 'show'])->name('company.show');

        });
    });

    Route::group(['namespace' => 'Account', 'prefix' => 'account'], function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.index');
        Route::patch('/edit', [AccountController::class, 'update'])->name('account.update');
        Route::patch('/password', [AccountController::class, 'password'])->name('account.password.update');
    });

    Route::group(['namespace' => 'Employee', 'prefix' => 'employee'], function () {
        // For DataTables
        Route::post('/get', [EmployeeTableController::class, 'invoke'])->name('employee.get');


        // Employee CRUD
        Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/', [EmployeeController::class, 'store'])->name('employee.store');
        Route::group(['prefix' => '{employee}'], function () {
            Route::get('/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
            Route::patch('/edit', [EmployeeController::class, 'update'])->name('employee.update');
            Route::delete('/delete', [EmployeeController::class, 'destroy'])->name('employee.destroy');
            Route::get('/show', [EmployeeController::class, 'show'])->name('employee.show');

        });
    });
});