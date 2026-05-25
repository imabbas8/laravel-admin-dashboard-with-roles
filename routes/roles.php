<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\RoleController;


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::get('role/list', [RoleController::class , 'index'])->middleware('RoutePermission:role-list')->name('role-list');

    Route::post('role/create', [RoleController::class , 'store'])
        ->middleware('RoutePermission:role-create')->name('role-create');
    Route::get('role/edit/{id}', [RoleController::class , 'edit'])->middleware('RoutePermission:role-edit')->name('role-edit');
    Route::post('role/update', [RoleController::class , 'update'])->middleware('RoutePermission:role-edit')->name('role-update');
    Route::post('role/delete', [RoleController::class , 'destroy'])->middleware('
    RoutePermission:role-delete')->name('role-delete');
});

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'role:super-admin']], function () {

    Route::get('permission/refresh', [RoleController::class , 'permissionRefresh'])->middleware('RoutePermission:super-permission-refresh')->name('super-permission-refresh');

});
