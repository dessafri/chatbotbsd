<?php

use App\Http\Controllers\Api\ApiBuktiFakturController;
use App\Http\Controllers\PenagihanController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('api')->group(function () {
    // Semua route di bawah ini akan memiliki prefix 'api' dan middleware 'token.auth'
    Route::post('bukti-image-faktur', [ApiBuktiFakturController::class, 'index']);
    Route::get('get-customer', [ApiBuktiFakturController::class, 'getCustomer']);
});
