<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;

Route::get('/user', function (Request $request) {
    return Auth::user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'admin'
], function () {
    // Rutas abiertas
    // Rutas autenticadas con token
    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::apiResource('/role', App\Http\Controllers\Admin\RoleController::class)->only(['index', 'show']);
        Route::apiResource('/module', App\Http\Controllers\Admin\ModuleController::class)->only(['index', 'show']);
        Route::get('module/{module}/role', [App\Http\Controllers\Admin\ModuleController::class, 'get_roles']);
        Route::get('role/{role}/role_permisions', [App\Http\Controllers\Admin\RoleController::class, 'role_permisions']);
        Route::apiResource('/permission', App\Http\Controllers\Admin\PermissionController::class)->only(['index']);
        Route::patch('role/{role}/permission', [App\Http\Controllers\Admin\RoleController::class,'set_or_remove_permission']);
        Route::apiResource('/user', App\Http\Controllers\Admin\UserController::class)->only(['index', 'store','show']);
        Route::get('user/module_role_permision', [App\Http\Controllers\Admin\UserController::class, 'module_role_permision']);
        Route::get('user/{user}/module_role_state_user', [App\Http\Controllers\Admin\UserController::class, 'module_role_state_user']);
        Route::patch('user/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'set_or_remove_role']);
    });
});

