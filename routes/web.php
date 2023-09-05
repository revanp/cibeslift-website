<?php

use App\Http\Controllers\Backend\DashboardController;
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
        Route::get('', [DashboardController::class, 'index']);
    });
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
