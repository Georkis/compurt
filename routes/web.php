<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(uri: '/', action: [ DashboardController::class, 'index' ]);

Route::middleware(['auth.active', 'auth:sanctum', config('jetstream.auth_session'), 'verified' ])->group(function () {
    //Auth Routes security
    Route::get(uri: '/dashboard', action: [ DashboardController::class, 'dashboard' ])->name(name: 'dashboard');
    Route::get(uri: '/users', action: [ UserController::class, 'index' ])->name(name: 'users.index')->middleware([
        'permission:Read user'
    ]);
    Route::post(uri: '/users', action: [ UserController::class, 'store' ])->name(name: 'users.store')->middleware([
        'permission:New user'
    ]);
    Route::put(uri: '/users/{id}', action: [ UserController::class, 'update' ])->name(name: 'users.update')->middleware([
        'permission:Update user'
    ]);
    Route::post(uri: '/users/active/{id}', action: [ UserController::class, 'active' ])->name(name: 'users.active');

    //Sliders resources
    Route::post(uri: '/sliders', action: [ SliderController::class, 'store' ])->name(name: 'sliders.store')->middleware([
        'permission:New slider'
    ]);
    Route::post(uri: '/seccions/{id}', action: [ SliderController::class, 'update' ])->name(name: 'sliders.update')->middleware([
        'permission:Update slider'
    ]);
    Route::get(uri: '/sliders', action: [ SliderController::class, 'index' ])->name(name: 'sliders.index')->middleware([
        'permission:Read slider'
    ]);
    Route::delete(uri: '/seccions/{id}', action: [ SliderController::class, 'destroy' ])->name(name: 'sliders.destroy')->middleware([
        'permission:Destroy slider'
    ]);

    //Roles
    Route::get(uri: 'roles', action: [ RoleController::class, 'index'])->name(name: 'roles.index')->middleware([
        'permission:Update role'
    ]);
});
