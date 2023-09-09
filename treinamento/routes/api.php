<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MyUserController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('ability:admin')->group(function () {
        Route::get('/company', [CompanyController::class, 'index']);
        Route::get('/company/{company}', [CompanyController::class, 'show']);
        Route::post('/company', [CompanyController::class, 'store']);
        Route::put('/company/{company}', [CompanyController::class, 'update']);
        Route::delete('/company/{company}', [CompanyController::class, 'destroy']);
        
        // adicionar usuário em uma company
        // listar usuários de uma empresa específica
        
        Route::get('/admin/myuser', [MyUserController::class, 'index']); // admin
        Route::get('/myuser/{myuser}', [MyUserController::class, 'show']); // admin
        Route::put('/myuser/{myuser}', [MyUserController::class, 'update']); // admin
        Route::delete('/myuser/{myuser}', [MyUserController::class, 'destroy']); // admin
    });
    
    Route::middleware(('ability:client,admin'))->group(function () {
        Route::get('/myuser', [MyUserController::class, 'showMe']);
        Route::put('/myuser', [MyUserController::class, 'updateMe']);
        // listar empresas do própro usuário
    }); 

    // Route::get('/address', [AddressController::class, 'index']);
    // Route::get('/address/{address}', [AddressController::class, 'show']);
    // Route::post('/address', [AddressController::class, 'store']);
    // Route::put('/address/{address}', [AddressController::class, 'update']);
    // Route::delete('/address/{address}', [AddressController::class, 'destroy']);
    
    
});

Route::post('/admin/myuser', [MyUserController::class, 'storeAdmin']); // admin
Route::post('/myuser', [MyUserController::class, 'storeClient']);
Route::post('/login', [MyUserController::class, 'login']); 
