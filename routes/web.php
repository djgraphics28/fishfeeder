<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FishpondController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile-avatar-update', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    //Devices
    Route::resource('devices', DeviceController::class);

    //Fishponds
    Route::resource('fishponds', FishpondController::class);

    //Settings
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
});
