<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\ModulesListController;


Route::group(['as' => 'admin.', 'prefix' => 'modules', 'middleware' => ['auth', 'role:super-admin']], function () {

    Route::get('list', [ModulesListController::class , 'index'])->middleware('RoutePermission:super-modules-list')->name('super-modules-list');

    
});