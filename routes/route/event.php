<?php

use App\Http\Controllers\Admin\Event\EventController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('show');
    Route::get('/data', [EventController::class, 'data'])->name('data');
    Route::post('/store', [EventController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [EventController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('delete');
    Route::delete('/selected-delete/{ids}', [EventController::class, 'multipleDelete'])->name('multiple-delete');
});
