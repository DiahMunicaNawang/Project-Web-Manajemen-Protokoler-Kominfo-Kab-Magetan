<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Person\RoleController;

Route::group(['prefix' => 'user', 'as' => 'user'], function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/roles/data', [RoleController::class, 'data'])->name('role.data');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/roles/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/roles/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
});
?>