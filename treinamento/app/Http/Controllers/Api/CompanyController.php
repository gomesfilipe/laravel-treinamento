<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function __construct(private CompanyRepositoryInterface $repository) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = $this->repository->getAll();
        return response()->json($companies, Response::HTTP_OK);
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
    public function store(StoreCompanyRequest $request)
    {
        // dd($request->validated());
        $company = $this->repository->store($request->validated());
        return response()->json($company, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $company = $this->repository->get($id);
        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Company $company)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, int $id)
    {
        $company = $this->repository->update($id, $request->all());
        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->noContent();
    }

    public function indexUsersFromCompany(int $id) {
        $users = $this->repository->getUsers($id);
        return response()->json($users, Response::HTTP_OK);
    }

    public function addUserInCompany(int $companyId, int $userId) {
        $this->repository->addUser($companyId, $userId);
        return response()->noContent();
    }
}
