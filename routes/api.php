
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/shipping-label'], function () {

    Route::get('/print', [App\Http\Controllers\ShippingLabelController::class, 'index']);

    Route::post('/new', [App\Http\Controllers\ShippingLabelController::class, 'store']);

    Route::put('/print/{id}', [App\Http\Controllers\ShippingLabelController::class, 'print']);

    Route::get('/status', [App\Http\Controllers\ShippingLabelController::class, 'status']);

    Route::get('/reprints-list/{created}', [App\Http\Controllers\ShippingLabelController::class, 'searchreprint']);

    Route::get('/search/{trf}', [App\Http\Controllers\ShippingLabelController::class, 'search']);

    Route::put('/patch-update/{trf}', [App\Http\Controllers\ShippingLabelController::class, 'patchUpdate']);

    //   Route::get('/reprint/{id}',[App\Http\Controllers\ShippingLabelController::class,'reprint']);
});


Route::group(['prefix' => '/print-label'], function () {

    Route::get('/trf/{transfer_number}', [App\Http\Controllers\PrintedLabelController::class, 'printall']);

    Route::post('/{transfer_number}', [App\Http\Controllers\PrintedLabelController::class, 'storeprint']);

    Route::put('/{id}', [App\Http\Controllers\PrintedLabelController::class, 'updateprintdata']);

    Route::get('/id/{id}', [App\Http\Controllers\PrintedLabelController::class, 'showprintdata']);
});




Route::group(['prefix' => '/reprint-label'], function () {

    Route::post('/ctn/{counter_number}', [App\Http\Controllers\PrintedLabelController::class, 'reprintStore']);

    Route::get('/ctn', [App\Http\Controllers\PrintedLabelController::class, 'reprintGetAll']);

    Route::put('/ctn/update/{counter_number}', [App\Http\Controllers\PrintedLabelController::class, 'reprintUpdate']);
});


Route::fallback(function () {
    abort(404, 'API resource not found');
});
