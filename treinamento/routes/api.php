<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MyUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('ability:admin')->group(function () {
        Route::get('/companies', [CompanyController::class, 'index']);
        Route::get('/company/{id}', [CompanyController::class, 'show']);
        Route::post('/company', [CompanyController::class, 'store']);
        Route::put('/company/{id}', [CompanyController::class, 'update']);
        Route::delete('/company/{id}', [CompanyController::class, 'destroy']);
        
        // adicionar usuário em uma company
        Route::post('/company/{company_id}/user/{user_id}', [CompanyController::class, 'addUserInCompany'])
            ->where(['company_id', 'user_id'], '[0-9]+');

        // listar usuários de uma empresa específica
        Route::get('/company/{id}/users', [CompanyController::class, 'indexUsersFromCompany']);

        // listas empresas de um usuário específico
        Route::get('/user/{id}/companies', [MyUserController::class, 'indexCompaniesFromUser']);
        
        Route::get('/users', [MyUserController::class, 'index']);
        Route::get('/user/{id}', [MyUserController::class, 'show']);
        Route::put('/user/{id}', [MyUserController::class, 'update']);
        Route::delete('/user/{id}', [MyUserController::class, 'destroy']);
        Route::post('/admin-user', [MyUserController::class, 'storeAdmin']);

        // atualizar foto de perfil de outro user
        Route::post('/user-update-profile-picture/{id}', [MyUserController::class, 'uploadProfilePicture']);
    });
    
    Route::middleware(('ability:client,admin'))->group(function () {
        Route::get('/my-user', [MyUserController::class, 'showMe']);
        Route::put('/my-user', [MyUserController::class, 'updateMe']);

        // listar empresas do próprio usuário
        Route::get('/my-user-companies', [MyUserController::class, 'indexMyCompanies']);
        
        // atualizar foto de perfil
        Route::post('/my-user-update-profile-picture', [MyUserController::class, 'uploadMyProfilePicture']);
    }); 

    // Route::get('/address', [AddressController::class, 'index']);
    // Route::get('/address/{id}', [AddressController::class, 'show']);
    // Route::post('/address', [AddressController::class, 'store']);
    // Route::put('/address/{id}', [AddressController::class, 'update']);
    // Route::delete('/address/{id}', [AddressController::class, 'destroy']);
});

Route::post('/client-user', [MyUserController::class, 'storeClient']);
Route::post('/login', [MyUserController::class, 'login']); 

// token admin
// admin@teste.com.br
// 123456
// Bearer 1|XYlduTLKah3Y9dzhhVx6llCaXWL5rkAUzyNEb7Ina00f9206

// token client
// client@teste.com.br
// 123456
// Bearer 2|gfHqjG186AGX9x1VmF27gxp3ouqo0YLSecpfXiSja40a6aee