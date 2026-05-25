<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\URL;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider and all of them will | be assigned to the "web" middleware group. Make something great! | */

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();


Route::group(['as' => 'admin.', 'prefix' => 'user','middleware' => ['auth']
], function () {
    Route::get('/dashboard', [HomeController::class , 'index'])->name('dashboard');

    // User
    Route::get('list', [UserController::class , 'index'])->middleware('RoutePermission:user-list')->name('user-list');
    Route::get('create', [UserController::class , 'create'])->middleware('RoutePermission:user-create')->name('user-create');
    Route::post('store', [UserController::class , 'store'])->middleware('RoutePermission:user-create')->name('user-store');
    Route::get('edit/{id}', [UserController::class , 'edit'])->middleware('RoutePermission:user-edit')->name('user-edit');
    Route::post('update/{id}', [UserController::class , 'update'])->middleware('RoutePermission:user-edit')->name('user-update');


    // Route::get('user/permission/{id}', [UserController::class , 'permission'])->name('user-permission');
    // Route::post('user/permission/update/{id}', [UserController::class , 'updatePermission'])->name('user-permission-update');

    Route::post('delete', [UserController::class , 'destroy'])->middleware('RoutePermission:user-delete')->name('user-delete');
    Route::get('trash/list', [UserController::class , 'trash'])->middleware('RoutePermission:user-trash-list')->name('user-trash-list');
    Route::post('trash/restore', [UserController::class , 'restore'])->middleware('RoutePermission:user-trash-restore')->name('user-trash-restore');

    

    Route::get('profile/setting', [UserController::class , 'profile'])->middleware('RoutePermission:profile-setting')->name('profile-setting');

    Route::post('profile/update', [UserController::class , 'profileUpdate'])->middleware('RoutePermission:profile-setting')->name('profile-update');
    Route::get('password/change', [UserController::class , 'ChangePassword'])->middleware('RoutePermission:profile-setting')->name('password-change');
    Route::post('password/update', [UserController::class , 'UpdatePassword'])->middleware('RoutePermission:profile-setting')->name('password-update');



// End User
});

// Role


include_once __DIR__ . '/roles.php';
include_once __DIR__ . '/modules.php';
// End Role




Route::get('/home', [App\Http\Controllers\HomeController::class , 'index'])->name('home');
