<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UpdateUserController;
use Illuminate\Support\Facades\{Route, Auth};

Auth::routes(['verify' => true]);
Route::get('verify/{token}', 'VerificationController@verify')->name('verify')->middleware('verified');

Route::middleware(['auth','verified','actived'])->group(function () {
    Route::prefix('my-profile')->controller(MyProfileController::class)->group(function() {
        Route::get('/', 'index')->name('my.profile.index');
        Route::put('/', 'update')->name('my.profile.update');
    });

    Route::get('/', HomeController::class)->name('home');

    Route::get('/show/{id}',[ShowController::class, 'show'])->name('show.show');
    Route::put('/show/{id}',[ShowController::class, 'update'])->name('show.update');
    

    Route::prefix('user')->middleware('roled')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('user.index');
            Route::get('/list', 'list')->name('user.list');
            Route::delete('/{user}', 'delete')->name('user.delete');
        }
        );
    });
    Route::prefix('tag')->group(function () {
        Route::controller(TagController::class)->group(function () {
            Route::get('/','index')->name('tag.index'); // show
            Route::get('/list','list')->name('tag.list'); 
            Route::get('/create','create')->name('tag.create'); // create
            Route::put('/create','store')->name('tag.store'); // store create
            Route::get('/{tag}','edit')->name('tag.edit'); // edit
            Route::put('/{tag}','update')->name('tag.update'); // update
            Route::delete('/{tag}','destroy')->name('tag.destroy'); // delete
        });
    });

    Route::prefix('category')->controller(CategoryController::class)->group(function () {
            Route::get('/','index')->name('category.index');
            Route::get('/list','list')->name('category.list');
            Route::get('/create','create')->name('category.create');
            Route::put('/create','store')->name('category.store');
            Route::get('/{category}','edit')->name('category.edit');
            Route::put('/{category}','update')->name('category.update');
            Route::delete('/{category}','destroy')->name('category.destroy');
    });

});


