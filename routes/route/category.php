<?php

use App\Http\Controllers\Admin\Master\Category\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'category', 'as' => 'category'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/data', [CategoryController::class, 'data'])->name('data');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    Route::delete('/selected-delete/{ids}', [CategoryController::class, 'multipleDelete'])->name('delete');
});

