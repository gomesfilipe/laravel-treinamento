<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct(private CompanyRepositoryInterface $repository) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $companies = $this->repository->get();
        return response()->json($companies, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = $this->repository->store($request->validated());
        return response()->json($company, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $company = $this->repository->find($id);
        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, int $id): JsonResponse
    {
        $company = $this->repository->update($id, $request->validated());
        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response
    {
        $this->repository->delete($id);
        return response()->noContent();
    }

    public function indexUsersFromCompany(int $id): JsonResponse {
        $users = $this->repository->getUsers($id);
        return response()->json($users, Response::HTTP_OK);
    }

    public function addUserInCompany(int $companyId, int $userId): Response {
        $this->repository->addUser($companyId, $userId);
        return response()->noContent();
    }
}
