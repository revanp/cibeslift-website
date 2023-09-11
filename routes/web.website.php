<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend
Route::get('/', function(){
    return redirect(url('id'));
});

Route::group(['prefix' => '{locale}', 'as' => '', 'middleware' => ['setLocale']], function(){
    Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
});
