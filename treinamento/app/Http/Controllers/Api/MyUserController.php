<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMyUserRequest;
use App\Http\Requests\UpdateMyUserRequest;
use App\Http\Requests\UploadProfilePictureRequest;
use App\Notifications\UserCreated;
use App\Repositories\Interfaces\MyUserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MyUserController extends Controller
{
    public function __construct(private MyUserRepositoryInterface $repository) {

    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = $this->repository->get();
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeClient(StoreMyUserRequest $request): JsonResponse
    {
        $user = $this->repository->store($request->validated(), false);
        $token = $user->createToken('token', ['client']);
        $user['token'] = $token->plainTextToken;

        $user->notify(new UserCreated($user));
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function storeAdmin(StoreMyUserRequest $request): JsonResponse
    {   
        $user = $this->repository->store($request->validated(), true);
        $token = $user->createToken('token', ['admin']);
        $user['token'] = $token->plainTextToken;
        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->repository->find($id);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMyUserRequest $request, int $id): JsonResponse
    {
        $user = $this->repository->update($id, $request->validated());
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response
    {
        $this->repository->delete($id);
        return response()->noContent();
    }

    public function login(Request $request): JsonResponse
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

    public function showMe(Request $request): JsonResponse
    {
        $user = $request->user();
        return response()->json($user, Response::HTTP_OK);
    }

    public function updateMe(UpdateMyUserRequest $request): JsonResponse
    {
        $user = $request->user();
        $userModel = $this->repository->update($user->id, $request->validated());
        return response()->json($userModel, Response::HTTP_OK);
    }

    public function indexCompaniesFromUser(int $id): JsonResponse
    {
        $companies = $this->repository->getCompanies($id);
        return response()->json($companies, Response::HTTP_OK);
    }

    public function indexMyCompanies(Request $request): JsonResponse 
    {
        $user = $request->user();
        $companies = $this->repository->getCompanies($user->id);
        return response()->json($companies, Response::HTTP_OK);
    }

    public function uploadProfilePicture(UploadProfilePictureRequest $request, int $id): JsonResponse
    {
        $user = $this->repository->find($id);

        if($user->profile_picture !== null) {
            Storage::delete($user->profile_picture);
        }

        $file = $request->file('profile_picture');
        $url = Storage::put('public/profile_pictures', $file);

        $user = $this->repository->update($id, ['profile_picture' => $url]);
        
        return response()->json(['profile_picture' => $user->profile_picture], Response::HTTP_OK);
    }

    public function uploadMyProfilePicture(UploadProfilePictureRequest $request): JsonResponse
    {
        $user = $request->user();

        if($user->profile_picture !== null) {
            Storage::delete($user->profile_picture);
        }

        $file = $request->file('profile_picture');
        $url = Storage::put('public/profile_pictures', $file);

        $user = $this->repository->update($user->id, ['profile_picture' => $url]);
        
        return response()->json(['profile_picture' => $user->profile_picture], Response::HTTP_OK);
    }
}
