<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend
Route::get('/', function(){
    return redirect(url('id'));
});

Route::group(['prefix' => '{locale}', 'as' => '', 'middleware' => ['setLocale']], function(){
    Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
    Route::get('/about-us', [App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('index');
    Route::get('/blog', [App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('index');
    Route::get('/blog/detail', [App\Http\Controllers\Frontend\BlogController::class, 'detail'])->name('detail');
    Route::get('/faq', [App\Http\Controllers\Frontend\FaqController::class, 'index'])->name('index');
});
