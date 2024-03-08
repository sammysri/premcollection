<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::post('/login',  [ApiController::class, 'apiLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/hotels',  [ApiController::class, 'getAllHotels']);
    Route::get('/doctors',  [ApiController::class, 'getAllDoctors']);
    Route::get('/astrologers',  [ApiController::class, 'getAllAstrologers']);
    Route::get('/dinner-menus',  [ApiController::class, 'getAllDinnerMenu']);
    Route::get('/logout',  [ApiController::class, 'getLogout']);
});
