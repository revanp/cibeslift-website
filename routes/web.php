<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// CMS
Route::group(['prefix' => 'admin-cms', 'as' => 'admin-cms.'], function(){
    Route::get('login', [App\Http\Controllers\Backend\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Backend\LoginController::class, 'login'])->name('login');
    Route::get('logout', [App\Http\Controllers\Backend\LoginController::class, 'logout']);

    Route::group(['middleware' => 'auth'], function(){
        Route::get('', [App\Http\Controllers\Backend\DashboardController::class, 'index']);

        Route::group(['prefix' => 'content'], function(){
            Route::group(['prefix' => 'header-banner'], function(){
                Route::get('', [App\Http\Controllers\Backend\Content\HeaderBannerController::class, 'index']);
                Route::post('datatable', [App\Http\Controllers\Backend\Content\HeaderBannerController::class, 'index']);
                Route::get('create', [App\Http\Controllers\Backend\Content\HeaderBannerController::class, 'create']);
                Route::post('create', [App\Http\Controllers\Backend\Content\HeaderBannerController::class, 'store']);
                Route::get('edit/{id}', [App\Http\Controllers\Backend\Content\HeaderBannerController::class, 'edit']);
                Route::put('edit/{id}', [App\Http\Controllers\Backend\Content\HeaderBannerController::class, 'update']);
                Route::put('change-status', [App\Http\Controllers\Backend\Content\HeaderBannerController::class, 'changeStatus']);
                Route::get('delete/{id}', [App\Http\Controllers\Backend\Content\HeaderBannerController::class, 'delete']);
            });

            Route::group(['prefix' => 'faq'], function(){
                Route::group(['prefix' => 'categories'], function(){
                    Route::get('', [App\Http\Controllers\Backend\Content\Faq\CategoriesController::class, 'index']);
                    Route::post('datatable', [App\Http\Controllers\Backend\Content\Faq\CategoriesController::class, 'index']);
                    Route::get('create', [App\Http\Controllers\Backend\Content\Faq\CategoriesController::class, 'create']);
                    Route::post('create', [App\Http\Controllers\Backend\Content\Faq\CategoriesController::class, 'store']);
                    Route::get('edit/{id}', [App\Http\Controllers\Backend\Content\Faq\CategoriesController::class, 'edit']);
                    Route::put('edit/{id}', [App\Http\Controllers\Backend\Content\Faq\CategoriesController::class, 'update']);
                    Route::put('change-status', [App\Http\Controllers\Backend\Content\Faq\CategoriesController::class, 'changeStatus']);
                    Route::get('delete/{id}', [App\Http\Controllers\Backend\Content\Faq\CategoriesController::class, 'delete']);
                });

                Route::group(['prefix' => 'questions'], function(){
                    Route::get('', [App\Http\Controllers\Backend\Content\Faq\QuestionsController::class, 'index']);
                    Route::post('datatable', [App\Http\Controllers\Backend\Content\Faq\QuestionsController::class, 'index']);
                    Route::get('create', [App\Http\Controllers\Backend\Content\Faq\QuestionsController::class, 'create']);
                    Route::post('create', [App\Http\Controllers\Backend\Content\Faq\QuestionsController::class, 'store']);
                    Route::get('edit/{id}', [App\Http\Controllers\Backend\Content\Faq\QuestionsController::class, 'edit']);
                    Route::post('edit/{id}', [App\Http\Controllers\Backend\Content\Faq\QuestionsController::class, 'update']);
                    Route::put('change-status', [App\Http\Controllers\Backend\Content\Faq\QuestionsController::class, 'changeStatus']);
                    Route::get('delete/{id}', [App\Http\Controllers\Backend\Content\Faq\QuestionsController::class, 'delete']);
                });
            });

            Route::group(['prefix' => 'news'], function(){
                Route::group(['prefix' => 'categories'], function(){
                    Route::get('', [App\Http\Controllers\Backend\Content\News\CategoriesController::class, 'index']);
                    Route::post('datatable', [App\Http\Controllers\Backend\Content\News\CategoriesController::class, 'index']);
                    Route::get('create', [App\Http\Controllers\Backend\Content\News\CategoriesController::class, 'create']);
                    Route::post('create', [App\Http\Controllers\Backend\Content\News\CategoriesController::class, 'store']);
                    Route::get('edit/{id}', [App\Http\Controllers\Backend\Content\News\CategoriesController::class, 'edit']);
                    Route::put('edit/{id}', [App\Http\Controllers\Backend\Content\News\CategoriesController::class, 'update']);
                    Route::put('change-status', [App\Http\Controllers\Backend\Content\News\CategoriesController::class, 'changeStatus']);
                    Route::get('delete/{id}', [App\Http\Controllers\Backend\Content\News\CategoriesController::class, 'delete']);
                });

                Route::group(['prefix' => 'news'], function(){
                    Route::get('', [App\Http\Controllers\Backend\Content\News\NewsController::class, 'index']);
                    Route::post('datatable', [App\Http\Controllers\Backend\Content\News\NewsController::class, 'index']);
                    Route::get('create', [App\Http\Controllers\Backend\Content\News\NewsController::class, 'create']);
                    Route::post('create', [App\Http\Controllers\Backend\Content\News\NewsController::class, 'store']);
                    Route::get('edit/{id}', [App\Http\Controllers\Backend\Content\News\NewsController::class, 'edit']);
                    Route::put('edit/{id}', [App\Http\Controllers\Backend\Content\News\NewsController::class, 'update']);
                    Route::put('change-status', [App\Http\Controllers\Backend\Content\News\NewsController::class, 'changeStatus']);
                    Route::get('delete/{id}', [App\Http\Controllers\Backend\Content\News\NewsController::class, 'delete']);
                });
            });
        });

        Route::group(['prefix' => 'products'], function(){
            Route::group(['prefix' => 'technologies'], function(){
                Route::get('', [App\Http\Controllers\Backend\Products\TechnologiesController::class, 'index']);
                Route::post('datatable', [App\Http\Controllers\Backend\Products\TechnologiesController::class, 'index']);
                Route::get('create', [App\Http\Controllers\Backend\Products\TechnologiesController::class, 'create']);
                Route::post('create', [App\Http\Controllers\Backend\Products\TechnologiesController::class, 'store']);
                Route::get('edit/{id}', [App\Http\Controllers\Backend\Products\TechnologiesController::class, 'edit']);
                Route::post('edit/{id}', [App\Http\Controllers\Backend\Products\TechnologiesController::class, 'update']);
                Route::put('change-status', [App\Http\Controllers\Backend\Products\TechnologiesController::class, 'changeStatus']);
                Route::get('delete/{id}', [App\Http\Controllers\Backend\Products\TechnologiesController::class, 'delete']);
            });

            Route::group(['prefix' => 'products'], function(){
                Route::get('', [App\Http\Controllers\Backend\Products\ProductsController::class, 'index']);
                Route::post('datatable', [App\Http\Controllers\Backend\Products\ProductsController::class, 'index']);
                Route::get('view/{id}', [App\Http\Controllers\Backend\Products\ProductsController::class, 'view']);
                Route::post('validation', [App\Http\Controllers\Backend\Products\ProductsController::class, 'validation']);
                Route::get('create', [App\Http\Controllers\Backend\Products\ProductsController::class, 'create']);
                Route::post('create', [App\Http\Controllers\Backend\Products\ProductsController::class, 'store']);
                Route::get('edit/{id}', [App\Http\Controllers\Backend\Products\ProductsController::class, 'edit']);
                Route::post('edit/{id}', [App\Http\Controllers\Backend\Products\ProductsController::class, 'update']);
                Route::put('change-status', [App\Http\Controllers\Backend\Products\ProductsController::class, 'changeStatus']);
                Route::get('delete/{id}', [App\Http\Controllers\Backend\Products\ProductsController::class, 'delete']);

                Route::group(['prefix' => 'customizations/{id}'], function(){
                    Route::get('', [App\Http\Controllers\Backend\Products\Products\CustomizationController::class, 'index']);
                    Route::get('create', [App\Http\Controllers\Backend\Products\Products\CustomizationController::class, 'create']);
                    Route::post('create', [App\Http\Controllers\Backend\Products\Products\CustomizationController::class, 'store']);
                    Route::get('edit/{idCustomization}', [App\Http\Controllers\Backend\Products\Products\CustomizationController::class, 'edit']);
                    Route::post('edit/{idCustomization}', [App\Http\Controllers\Backend\Products\Products\CustomizationController::class, 'update']);
                    Route::put('change-status', [App\Http\Controllers\Backend\Products\Products\CustomizationController::class, 'changeStatus']);
                    Route::get('delete/{idCustomization}', [App\Http\Controllers\Backend\Products\Products\CustomizationController::class, 'delete']);

                    Route::group(['prefix' => 'options/{idCustomization}'], function(){
                        Route::get('', [App\Http\Controllers\Backend\Products\Products\Customization\OptionController::class, 'index']);
                        Route::get('create', [App\Http\Controllers\Backend\Products\Products\Customization\OptionController::class, 'create']);
                        Route::post('create', [App\Http\Controllers\Backend\Products\Products\Customization\OptionController::class, 'store']);
                        Route::get('edit/{idOption}', [App\Http\Controllers\Backend\Products\Products\Customization\OptionController::class, 'edit']);
                        Route::post('edit/{idOption}', [App\Http\Controllers\Backend\Products\Products\Customization\OptionController::class, 'update']);
                        Route::put('change-status', [App\Http\Controllers\Backend\Products\Products\Customization\OptionController::class, 'changeStatus']);
                        Route::get('delete/{idOption}', [App\Http\Controllers\Backend\Products\Products\Customization\OptionController::class, 'delete']);
                    });
                });
            });
        });

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

            Route::group(['prefix' => 'pages'], function(){
                Route::get('', [App\Http\Controllers\Backend\Settings\PagesController::class, 'index']);
                Route::post('datatable', [App\Http\Controllers\Backend\Settings\PagesController::class, 'index']);
                Route::get('edit/{id}', [App\Http\Controllers\Backend\Settings\PagesController::class, 'edit']);
                Route::put('edit/{id}', [App\Http\Controllers\Backend\Settings\PagesController::class, 'update']);
            });
        });
    });

    Route::get('delete-media/{idMedia}', [App\Http\Controllers\Controller::class, 'deleteMedia']);
});
