<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ContactDataController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\SocialNetController;

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

    //ContactData
    Route::get(uri: '/contact/data', action: [ ContactDataController::class, 'index' ])->name(name: 'contactdata.index');
    Route::post(uri: '/contact/{id}', action: [ ContactDataController::class, 'update' ])->name(name: 'contactdata.update');

    //About
    Route::get(uri: '/about', action: [AboutController::class, 'index'])->name(name: 'about.index');
    Route::post(uri: '/about', action: [AboutController::class, 'store'])->name(name: 'about.store');
    Route::put(uri: '/about/{id}', action: [AboutController::class, 'update'])->name(name: 'about.update');
    Route::delete(uri: '/about/{id}', action: [AboutController::class, 'destroy'])->name(name: 'about.destroy');

    //Service
    Route::get(uri: '/service', action: [ServiceController::class, 'index'])->name(name: 'service.index');
    Route::post(uri: '/service', action: [ServiceController::class, 'store'])->name(name: 'service.store');
    Route::post(uri: '/service/{id}', action: [ServiceController::class, 'update'])->name(name: 'service.update');
    Route::delete(uri: '/service/{id}', action: [ServiceController::class, 'destroy'])->name(name: 'service.destroy');

    //Entity Testimonial
    Route::get(uri: '/testimonial', action: [ TestimonialController::class, 'index' ])->name(name: 'testimonial.index');
    Route::post(uri: '/testimonial', action: [ TestimonialController::class, 'store' ])->name(name: 'testimonial.store');
    Route::post(uri: '/testimonial/{id}', action: [ TestimonialController::class, 'update' ])->name(name: 'testimonial.update');
    Route::delete(uri: '/testimonial/{id}', action: [ TestimonialController::class, 'destroy' ])->name(name: 'testimonial.destroy');

    //Entity Social net
    Route::get(uri: '/socialnet', action: [ SocialNetController::class, 'index' ])->name('socialnet.index');
    Route::put(uri: '/socialnet/{id}', action: [ SocialNetController::class, 'update' ])->name('socialnet.update');

    //Roles
    Route::get(uri: 'roles', action: [ RoleController::class, 'index'])->name(name: 'roles.index')->middleware([
        'permission:Update role'
    ]);
});
