<?php

use App\Http\Controllers\Api\v1\Admin\PeriodController as AdminPeriodController;
use App\Http\Controllers\Api\v1\Admin\CottageController as AdminCottageController;
use App\Http\Controllers\Api\v1\Admin\CottageTypeController as AdminCottageTypeController;
use App\Http\Controllers\Api\v1\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Api\v1\Admin\ImageController as AdminImageController;
use App\Http\Controllers\Api\v1\Admin\PriceController as AdminPriceController;
use App\Http\Controllers\Api\v1\Admin\ServiceCategoryController as AdminServiceCategoryController;
use App\Http\Controllers\Api\v1\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\v1\CottageController;
use App\Http\Controllers\Api\v1\CottageTypeController;
use App\Http\Controllers\Api\v1\GalleryController;
use App\Http\Controllers\Api\v1\ImageController;
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
    Route::prefix('admin')
        //->middleware('admin')
        ->name('admin.')
        ->group(function () {
            Route::apiResources([
                'images' => AdminImageController::class,
                'galleries' => AdminGalleryController::class,
                'cottage-types' => AdminCottageTypeController::class,
                'cottages' => AdminCottageController::class,
                'service-categories' => AdminServiceCategoryController::class,
                'services' => AdminServiceController::class,
                'periods' => AdminPeriodController::class,
                'prices' => AdminPriceController::class,
            ]);
            Route::get('prices/{cottage?}', [AdminPriceController::class, 'index']);
        });
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
});
