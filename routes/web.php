<?php

use App\Http\Controllers\CampController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/home', function(){
        return view('home');
    });

    //camps
    Route::get('/camps', [CampController::class, 'index'])->name('camps.index');
    Route::post('/store-camp', [CampController::class, 'store'])->name('camps.store');

    //testing
    Route::get('/testing', [TestController::class, 'index'])->name('test.index');
    Route::post('/getSheetNames', [TestController::class, 'getSheetNames'])->name('test.sheetNames');
});

require __DIR__.'/auth.php';
