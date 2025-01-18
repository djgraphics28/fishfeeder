<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FeedController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\TemperatureController;


Route::post('/insert-temp', [TemperatureController::class, 'store'])->name('insert-temp');
Route::post('/check-schedule', [ScheduleController::class, 'checkSchedule'])->name('check-schedule');
Route::post('/check-feeding-status', [FeedController::class, 'checkFeedingStatus'])->name('check-feeding-status');
