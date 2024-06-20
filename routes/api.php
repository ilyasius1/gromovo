<?php

declare(strict_types=1);

use App\Http\Controllers\Api\v1\CottageController;
use App\Http\Controllers\Api\v1\CottageTypeController;
use App\Http\Controllers\Api\v1\GalleryController;
use App\Http\Controllers\Api\v1\ImageController;
use App\Http\Controllers\Api\v1\PriceController;
use App\Http\Controllers\Api\v1\ReservationController;
use App\Http\Controllers\Api\v1\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('v1')->group(function () {
    Route::controller(ImageController::class)->group(function () {
        Route::get('/images','index');
        Route::get('/images/{image}','show');
    });
    Route::controller(GalleryController::class)->group(function () {
        Route::get('/galleries','index');
        Route::get('/galleries/{gallery}','show');
    });
    Route::controller(CottageTypeController::class)->group(function () {
        Route::get('/cottage-types','index');
        Route::get('/cottage-types/{cottage-type}','show');
    });
    Route::controller(CottageController::class)->group(function () {
        Route::get('/cottages','index');
        Route::get('/cottages/{cottage}','show');
    });
    Route::controller(ServiceController::class)->group(function () {
        Route::get('/services','index');
        Route::get('/services/{service}','show');
    });
    Route::controller(PriceController::class)->group(function () {
        Route::get('/prices','index');
        Route::get('/prices/{price}','show');
    });
    Route::controller(ReservationController::class)->group(function () {
        Route::get('/reservations','index');
        Route::get('/reservations/{reservation}','show');
        Route::post('/reservations','store');
    });
});
