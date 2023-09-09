<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

// CMS
Route::group(['prefix' => 'admin-cms'], function(){
    Route::get('login', [App\Http\Controllers\Backend\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Backend\LoginController::class, 'login'])->name('login');
    Route::get('logout', [App\Http\Controllers\Backend\LoginController::class, 'logout']);

    Route::group(['middleware' => 'auth'], function(){
        Route::get('', [App\Http\Controllers\Backend\DashboardController::class, 'index']);

        Route::group(['prefix' => 'settings'], function(){
            Route::group(['prefix' => 'users'], function(){
                Route::get('', [App\Http\Controllers\Backend\Settings\UsersController::class, 'index']);
                Route::post('datatable', [App\Http\Controllers\Backend\Settings\UsersController::class, 'index']);
                Route::get('create', [App\Http\Controllers\Backend\Settings\UsersController::class, 'create']);
                Route::post('create', [App\Http\Controllers\Backend\Settings\UsersController::class, 'store']);
                Route::get('edit/{id}', [App\Http\Controllers\Backend\Settings\UsersController::class, 'edit']);
                Route::put('edit/{id}', [App\Http\Controllers\Backend\Settings\UsersController::class, 'update']);
                Route::get('delete/{id}', [App\Http\Controllers\Backend\Settings\UsersController::class, 'delete']);
            });
        });
    });
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
