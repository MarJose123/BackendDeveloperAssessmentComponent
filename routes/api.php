<?php
/*
 * Copyright (c) 2023.  LF Backend Developer Assessment by Josie Noli Darang.
 */

use Illuminate\Support\Facades\Route;
use MarJose123\BackendDeveloperAssessmentComponent\Http\Controllers\AccountController;
use MarJose123\BackendDeveloperAssessmentComponent\Http\Controllers\AuthenticationController;
use MarJose123\BackendDeveloperAssessmentComponent\Http\Controllers\RoleController;

/*
 * Authentication API Route
 */
Route::prefix('auth')
    ->middleware('api')
    ->group(function () {
        Route::post('login', [AuthenticationController::class, 'login']);
        Route::post('logout', [AuthenticationController::class, 'logout'])
            ->middleware('auth:api');
        Route::post('refresh', [AuthenticationController::class, 'refresh'])
            ->middleware('auth:api');

    });

/*
 * User Security Control
 *
 * API Route for Roles
 */
Route::prefix('security')
    ->middleware(['api', 'auth:api'])
    ->group(function () {
        Route::post('role', [RoleController::class, 'store'])->middleware('role_or_permission:SUPER_USER|ADMIN|Add Role');
        Route::get('roles', [RoleController::class, 'roleList'])->middleware('role_or_permission:SUPER_USER|ADMIN|View Role');
        Route::delete('role/{id}', [RoleController::class, 'delete'])->middleware('role_or_permission:SUPER_USER|Delete Role');
        Route::get('permissions', [RoleController::class, 'permissionList'])->middleware('role_or_permission:SUPER_USER|ADMIN|View Permissions');
    });

/*
 * Profile API Route View
 */
Route::prefix('account')
    ->middleware(['auth:api', 'api'])
    ->group(function () {
        Route::get('/profile', [AccountController::class, 'profile']);
        Route::get('/users', [AccountController::class, 'index'])->middleware('role_or_permission:SUPER_USER|ADMIN|View User');
        Route::post('/user', [AccountController::class, 'store'])->middleware('role_or_permission:SUPER_USER|ADMIN|Add User');
        Route::delete('/user/{id}', [AccountController::class, 'destroy'])->middleware('role_or_permission:SUPER_USER|Delete User');
    });
