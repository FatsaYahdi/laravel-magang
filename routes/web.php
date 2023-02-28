<?php

use App\Http\Controllers\{CategoryController, HomeController, MyProfileController, PostController, PostShowController, ShowController, TagController, UserController, UpdateUserController,};
use Illuminate\Support\Facades\{Route, Auth};

Auth::routes(['verify' => true]);
Route::get('verify/{token}', 'VerificationController@verify')->name('verify')->middleware('verified');

// post show
Route::controller(PostShowController::class)->group(function () {
        Route::get('/', 'index')->name('home.index');
        Route::get('/posts/{post:slug}', 'show')->name('post.show');
        Route::put('/posts/{post:slug}','store')->name('post.comment');
        Route::get('/post/category/{category}','showCategory')->name('post.category');
        Route::get('/post/tag/{tag}','showTag')->name('post.tag');
})->name('home');

Route::middleware(['auth', 'verified', 'actived','spam','member'])->group(function () {
    // my profile
    Route::prefix('my-profile')->controller(MyProfileController::class)->group(function () {
        Route::get('/', 'index')->name('my.profile.index');
        Route::put('/', 'update')->name('my.profile.update');
    })->name('my.profile');

    // dashboard
    Route::get('/home', HomeController::class)->name('home.home');

    // user show
    Route::get('/show/{id}', [ShowController::class, 'show'])->name('show.show');
    Route::put('/show/{id}', [ShowController::class, 'update'])->name('show.update');

    // user
    Route::prefix('user')->middleware('roled')->group(function () {
        Route::controller(UserController::class)->group(function () {
                Route::get('/', 'index')->name('user.index');
                Route::get('/list', 'list')->name('user.list');
                Route::get('/create', 'create')->name('user.create');
                Route::put('/create', 'store')->name('user.store');
                Route::delete('/{user}', 'delete')->name('user.delete');
            }
        );
    })->name('user');

    // tag
    Route::prefix('tag')->middleware('spam')->group(function () {
        Route::controller(TagController::class)->group(function () {
            Route::get('/', 'index')->name('tag.index');
            Route::get('/list', 'list')->name('tag.list');
            Route::get('/create', 'create')->name('tag.create');
            Route::put('/create', 'store')->name('tag.store');
            Route::get('/{tag}', 'edit')->name('tag.edit');
            Route::put('/{tag}', 'update')->name('tag.update');
            Route::delete('/{tag}', 'destroy')->name('tag.destroy');
        }
        );
    })->name('tag');

    // category
    Route::prefix('category')->middleware('spam')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('category.index');
        Route::get('/list', 'list')->name('category.list');
        Route::get('/create', 'create')->name('category.create');
        Route::put('/create', 'store')->name('category.store');
        Route::get('/{category}', 'edit')->name('category.edit');
        Route::put('/{category}', 'update')->name('category.update');
        Route::delete('/{category}', 'destroy')->name('category.destroy');
    })->name('category');

    // post
    Route::prefix('post')->middleware('spam')->controller(PostController::class)->group(function () {
        Route::get('/', 'index')->name('post.index');
        Route::get('/list', 'list')->name('post.list');
        Route::get('/create', 'create')->name('post.create');
        Route::put('/create', 'store')->name('post.store');
        Route::get('/{post}', 'edit')->name('post.edit');
        Route::put('/{post}', 'update')->name('post.update');
        Route::delete('/{post}', 'destroy')->name('post.destroy');
    })->name('post');

});