<?php

use App\Http\Controllers\Api\AddressController;
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

Route::get('/address', [AddressController::class, 'index']);
Route::get('/address/{address}', [AddressController::class, 'show']);
Route::post('/address', [AddressController::class, 'store']);
Route::put('/address/{address}', [AddressController::class, 'update']);
Route::delete('/address/{address}', [AddressController::class, 'destroy']);
