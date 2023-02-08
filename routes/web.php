<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\UpdateUserController;
use Illuminate\Support\Facades\{Route, Auth};

Auth::routes(['verify' => true]);

Route::get('/', HomeController::class)->name('home');
Route::get('verify/{token}', 'VerificationController@verify')->name('verify')->middleware('verified');

// Route::get('/update/users/{id}',[UpdateUserController::class, 'edit'])->name('edit');
// Route::post('/update/users/submit',[UpdateUserController::class, 'update']);

Route::prefix('my-profile')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', [MyProfileController::class, 'index'])->name('my.profile.index');
    Route::put('/', [MyProfileController::class, 'update'])->name('my.profile.update');
});
Route::get('show',[ShowController::class, 'show'])->name('show');
Route::delete('show/{id}', [ShowController::class, 'destroy'])->name('show.destroy');