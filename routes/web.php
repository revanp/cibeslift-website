<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin-cms'], function(){
    Auth::routes();

    // Route::group(['middleware' => 'auth'], function(){
        Route::get('', [DashboardController::class, 'index']);
    // });
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
