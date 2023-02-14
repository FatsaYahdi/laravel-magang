<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ShowController;
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
});


