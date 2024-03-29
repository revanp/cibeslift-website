<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend
Route::get('/', function(){
    return redirect(url('id'));
});

Route::get('phpxinfo', function(){
    return phpinfo();
});

Route::post('form-contact-us', [App\Http\Controllers\Frontend\HomeController::class, 'formContactUs']);

Route::group(['prefix' => '{locale}', 'as' => '', 'middleware' => ['setLocale']], function(){
    Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

    Route::get('/about-us', [App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('index');
    Route::get('/about-us/get-manufacture', [App\Http\Controllers\Frontend\AboutController::class, 'getManufacture']);

    Route::get('/faq', [App\Http\Controllers\Frontend\FaqController::class, 'index'])->name('index');

    Route::get('/product', [\App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('product.index');
    Route::get('product/get-customization', [App\Http\Controllers\Frontend\ProductController::class, 'getCustomization']);
    Route::get('/product/{slug}', [App\Http\Controllers\Frontend\ProductController::class, 'product'])->name('product.category');
    Route::get('/product/{slug}/{productSlug}', [App\Http\Controllers\Frontend\ProductController::class, 'detail'])->name('detail');
    // Route::get('/product/detail', [App\Http\Controllers\Frontend\ProductController::class, 'detail'])->name('product.detail');


    Route::get('/blog', [App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('index');
    Route::get('/blog/{slug}', [App\Http\Controllers\Frontend\BlogController::class, 'detail'])->name('detail');

    Route::get('/installation', [\App\Http\Controllers\Frontend\InstallationController::class, 'index'])->name('index');
    Route::get('/installation/archive', [\App\Http\Controllers\Frontend\InstallationController::class, 'archive'])->name('archive');
    Route::get('/installation/detail', [\App\Http\Controllers\Frontend\InstallationController::class, 'detail'])->name('detail');
});

