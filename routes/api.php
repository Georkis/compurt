<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ContactDataController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\SocialNetController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriberController;

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

Route::get(uri: '/slider', action: [ SliderController::class, 'getSliders' ])->name('api.slider');
Route::get(uri: '/contact/data', action: [ ContactDataController::class, 'getContactData' ])->name('api.contact');
Route::get(uri: '/testimonials', action: [ TestimonialController::class, 'getTestimonials' ])->name('api.testimonial');
Route::get(uri: '/about', action: [ AboutController::class, 'getAbouts' ])->name('api.about');
Route::get(uri: '/social/nets', action: [ SocialNetController::class, 'getSocialNets' ])->name(name: 'api.socialnet');
Route::get(uri: '/service', action: [ ServiceController::class, 'getServices' ])->name(name: 'api.service');
Route::post(uri: '/subscriber/start', action: [ SubscriberController::class, 'store' ])->name(name: 'api.subscriber');
