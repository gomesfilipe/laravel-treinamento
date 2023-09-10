<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MyUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
        
        // adicionar usuário em uma company ok
        Route::post('/company/{company}/users/add/{user}', [CompanyController::class, 'addUserInCompany']);

        // listar usuários de uma empresa específica ok
        Route::get('/company/{company}/users', [CompanyController::class, 'indexUsersFromCompany']);

        // listas empresas de um usuário específico
        Route::get('/myuser/{myuser}/companies', [MyUserController::class, 'indexCompaniesFromUser']);
        
        Route::get('/admin/myuser', [MyUserController::class, 'index']);
        Route::get('/myuser/{myuser}', [MyUserController::class, 'show']);
        Route::put('/myuser/{myuser}', [MyUserController::class, 'update']);
        Route::delete('/myuser/{myuser}', [MyUserController::class, 'destroy']);
        Route::post('/admin/myuser', [MyUserController::class, 'storeAdmin']);
    });
    
    Route::middleware(('ability:client,admin'))->group(function () {
        Route::get('/myuser', [MyUserController::class, 'showMe']);
        Route::put('/myuser', [MyUserController::class, 'updateMe']);

        // listar empresas do próprio usuário
        Route::get('/myusercompanies', [MyUserController::class, 'indexMyCompanies']);
    }); 

    // Route::get('/address', [AddressController::class, 'index']);
    // Route::get('/address/{address}', [AddressController::class, 'show']);
    // Route::post('/address', [AddressController::class, 'store']);
    // Route::put('/address/{address}', [AddressController::class, 'update']);
    // Route::delete('/address/{address}', [AddressController::class, 'destroy']);
});

Route::post('/myuser', [MyUserController::class, 'storeClient']);
Route::post('/login', [MyUserController::class, 'login']); 

// token admin
// admin@teste.com.br
// 123456
// Bearer 1|XYlduTLKah3Y9dzhhVx6llCaXWL5rkAUzyNEb7Ina00f9206

// token client
// client@teste.com.br
// 123456
// Bearer 2|gfHqjG186AGX9x1VmF27gxp3ouqo0YLSecpfXiSja40a6aee