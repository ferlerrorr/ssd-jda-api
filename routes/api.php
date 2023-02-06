
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

Route::group(['prefix'=>'/shipping-label'],function(){

    Route::get('/print',[App\Http\Controllers\ShippingLabelController::class,'index']);

    Route::post('/new',[App\Http\Controllers\ShippingLabelController::class,'store']);
    
    Route::put('/print/{id}',[App\Http\Controllers\ShippingLabelController::class,'print']);
	
   Route::get('/status',[App\Http\Controllers\ShippingLabelController::class,'status']);

});

Route::fallback(function (){
    abort(404, 'API resource not found');
});
