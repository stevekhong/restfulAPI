<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObjectApiController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('object')->group(function () {
    Route::get( '/get_all_records', [ ObjectApiController::class, 'showAll' ] );
    Route::get( '/{mykey}', [ ObjectApiController::class, 'show' ] );
    Route::post( '/', [ ObjectApiController::class, 'process' ] );
});