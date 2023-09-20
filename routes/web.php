<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/about-us', [App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('index');
Route::get('/blog', [App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('index');
Route::get('/blog/detail', [App\Http\Controllers\Frontend\BlogController::class, 'detail'])->name('detail');
Route::get('/faq', [App\Http\Controllers\Frontend\FaqController::class, 'index'])->name('index');

Route::get('/product', [App\Http\Controllers\Frontend\ProductController::class, 'product'])->name('product');
Route::get('/product/detail', [App\Http\Controllers\Frontend\ProductController::class, 'detail'])->name('detail');

// CMS
Route::group(['prefix' => 'admin-cms'], function(){
    Auth::routes();

    Route::group(['middleware' => 'auth'], function(){
        Route::get('', [DashboardController::class, 'index']);
    });
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
