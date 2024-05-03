<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookingController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/hello',  [ApiController::class, 'hello']);
Route::post('/send-login-otp',  [ApiController::class, 'sendLoginOtp']);
Route::post('/verify-login-otp',  [ApiController::class, 'verifyLoginOtp']);
Route::post('/apply-membership',  [ApiController::class, 'applyMembership']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout',  [ApiController::class, 'getLogout']);
    Route::get('/store-list',  [ApiController::class, 'getAllStores']);
    Route::get('/hotels',  [ApiController::class, 'getAllHotels']);
    Route::get('/doctors',  [ApiController::class, 'getAllDoctors']);
    Route::get('/astrologers',  [ApiController::class, 'getAllAstrologers']);
    Route::get('/dinner-menus',  [ApiController::class, 'getAllDinnerMenu']);
    Route::get('/cars',  [ApiController::class, 'getAllCars']);
    Route::get('/doctor-categories',  [ApiController::class, 'getAllCategories']);
    Route::get('/my-booked-services',  [BookingController::class, 'getBookedServices']);
    Route::post('/save-profile',  [ApiController::class, 'postSaveProfile']);
    Route::get('/fetch-profile',  [ApiController::class, 'getProfile']);
    Route::get('/albums',  [ApiController::class, 'getAlbums']);
    Route::get('/album/{albumId}/images',  [ApiController::class, 'getAlbumImages']);
    Route::get('/banners',  [ApiController::class, 'getBanners']);

    foreach(['Hotel', 'Doctor', 'Astrologer', 'DinnerMenu', 'Car'] as $type) {
        Route::group(['prefix' => '{type}'], function () {
            Route::post('book', [BookingController::class, 'store']);
        });
    }    

});
Route::fallback(function () {
    return ['messge' => 'Not Found'];
});
