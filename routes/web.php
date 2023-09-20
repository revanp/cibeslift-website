<?php

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
Route::group(['prefix' => 'admin-cms', 'as' => 'admin-cms.'], function(){
    Route::get('login', [App\Http\Controllers\Backend\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Backend\LoginController::class, 'login'])->name('login');
    Route::get('logout', [App\Http\Controllers\Backend\LoginController::class, 'logout']);

    Route::group(['middleware' => 'auth'], function(){
        Route::get('', [App\Http\Controllers\Backend\DashboardController::class, 'index']);

        Route::group(['prefix' => 'settings'], function(){
            Route::group(['prefix' => 'roles'], function(){
                Route::get('', [App\Http\Controllers\Backend\Settings\RolesController::class, 'index']);
                Route::post('datatable', [App\Http\Controllers\Backend\Settings\RolesController::class, 'index']);
                Route::get('create', [App\Http\Controllers\Backend\Settings\RolesController::class, 'create']);
                Route::post('create', [App\Http\Controllers\Backend\Settings\RolesController::class, 'store']);
                Route::get('edit/{id}', [App\Http\Controllers\Backend\Settings\RolesController::class, 'edit']);
                Route::put('edit/{id}', [App\Http\Controllers\Backend\Settings\RolesController::class, 'update']);
                Route::put('change-status', [App\Http\Controllers\Backend\Settings\RolesController::class, 'changeStatus']);
                Route::get('delete/{id}', [App\Http\Controllers\Backend\Settings\RolesController::class, 'delete']);
            });

            Route::group(['prefix' => 'users'], function(){
                Route::get('', [App\Http\Controllers\Backend\Settings\UsersController::class, 'index']);
                Route::post('datatable', [App\Http\Controllers\Backend\Settings\UsersController::class, 'index']);
                Route::get('create', [App\Http\Controllers\Backend\Settings\UsersController::class, 'create']);
                Route::post('create', [App\Http\Controllers\Backend\Settings\UsersController::class, 'store']);
                Route::get('edit/{id}', [App\Http\Controllers\Backend\Settings\UsersController::class, 'edit']);
                Route::put('edit/{id}', [App\Http\Controllers\Backend\Settings\UsersController::class, 'update']);
                Route::put('change-status', [App\Http\Controllers\Backend\Settings\UsersController::class, 'changeStatus']);
                Route::get('delete/{id}', [App\Http\Controllers\Backend\Settings\UsersController::class, 'delete']);
            });

            Route::group(['prefix' => 'translations'], function(){
                Route::get('', [App\Http\Controllers\Backend\Settings\TranslationsController::class, 'index']);
                Route::post('update-value', [App\Http\Controllers\Backend\Settings\TranslationsController::class, 'updateValue']);
                Route::post('publish', [App\Http\Controllers\Backend\Settings\TranslationsController::class, 'publish']);
            });
        });
    });
});
