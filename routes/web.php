<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [LoginController::class, 'index'])->name('home');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/media/upload/{folderName}/{name}', [MediaController::class, 'store'])->name('media.upload');
Route::delete('/media/delete', [MediaController::class, 'removeFile'])->name('media.remove');
Route::post('/ckeditor/upload/{folderName}', [MediaController::class, 'ckEditorUpload'])->name('ckeditor.upload');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Add route here
    require_once __DIR__ . '/route/user-list.php';
    require_once __DIR__ . '/route/roles.php';
    require_once __DIR__ . '/route/event.php';
});
