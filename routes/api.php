<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Person\PersonController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['as' => 'api'], function () {
    Route::group(['prefix' => 'user/list', 'as' => 'user.list'], function () {
        Route::get('/', [PersonController::class, 'index'])->name('list.index');
        Route::get('/all-users', [PersonController::class, 'allUsers'])->name('list.all-users');
        Route::get('/data', [PersonController::class, 'data'])->name('list.data');
        Route::post('/store', [PersonController::class, 'store'])->name('list.store');
        Route::get('/edit/{id}', [PersonController::class, 'edit'])->name('list.edit');
        Route::put('/update/{id}', [PersonController::class, 'update'])->name('list.update');
        Route::delete('/delete/{id}', [PersonController::class, 'delete'])->name('list.delete');
        Route::delete('/selected-delete/{ids}', [PersonController::class, 'multipleDelete'])->name('list.selected-delete');
    });
});
