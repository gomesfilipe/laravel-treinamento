<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMyUserRequest;
use App\Http\Requests\UpdateMyUserRequest;
use App\Repositories\Interfaces\MyUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MyUserController extends Controller
{
    public function __construct(private MyUserRepositoryInterface $repository) {

    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->user());
        $users = $this->repository->getAll();
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function storeClient(StoreMyUserRequest $request)
    {
        $user = $this->repository->store($request->validated(), false);
        $token = $user->createToken('token', ['client']);
        $user['token'] = $token->plainTextToken;
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function storeAdmin(StoreMyUserRequest $request) 
    {
        $user = $this->repository->store($request->validated(), true);
        $token = $user->createToken('token', ['admin']);
        $user['token'] = $token->plainTextToken;
        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = $this->repository->get($id);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(MyUser $myUser)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMyUserRequest $request, int $id)
    {
        $user = $this->repository->update($id, $request->validated());
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->noContent();
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        
        if(Auth::attempt($credentials) === false) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        
        $user = $request->user();
        
        $ability = $user->type === 'admin' ? 'admin' : 'client';
        $token = $user->createToken('token', [$ability]);

        $user['token'] = $token->plainTextToken;
        
        return response()->json($user, Response::HTTP_OK);
    }

    public function showMe(Request $request)
    {
        $user = $request->user();
        return response()->json($user, Response::HTTP_OK);
    }

    public function updateMe(UpdateMyUserRequest $request)
    {
        $user = $request->user();
        $userModel = $this->repository->update($user->id, $request->validated());
        return response()->json($userModel, Response::HTTP_OK);
    }

    public function indexCompaniesFromUser(int $id) 
    {
        $companies = $this->repository->getCompanies($id);
        return response()->json($companies, Response::HTTP_OK);
    }

    public function indexMyCompanies(Request $request) 
    {
        $user = $request->user();
        $companies = $this->repository->getCompanies($user->id);
        return response()->json($companies, Response::HTTP_OK);
    }
}
