<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\AstrologerController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MenuController;

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

Route::get('/', function () {
    return redirect('/dashboard');
})->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class, 'postLogin'])->name('loginPost');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/change-password', [UserController::class, 'getChangePassword'])->name('changePassword');
    Route::post('/change-password', [UserController::class, 'postChangePassword'])->name('changePasswordPost');

    Route::resource('dinner-menus', MenuController::class);
    Route::get('doctor-category/{category?}', [DoctorController::class, 'category'])->name('category');
    Route::post('doctor-category/{category?}', [DoctorController::class, 'postCategory'])->name('categoryPost');
    Route::resource('doctors', DoctorController::class);
    Route::resource('hotels', HotelController::class);
    Route::resource('astrologers', AstrologerController::class);

    foreach(['user', 'admin'] as $type) {
        Route::group([
            'prefix' => $type, 
            'name' => $type . '.',
        ], function() {
            Route::resource('management', UserController::class);
        });
    }
    
});
