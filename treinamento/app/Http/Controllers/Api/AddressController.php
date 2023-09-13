<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function __construct(private AddressRepositoryInterface $repository) {

    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $addresses = $this->repository->get();
        return response()->json($addresses, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request): JsonResponse
    {
        $address = $this->repository->store($request->validated());
        return response()->json($address, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address): JsonResponse
    {
        return response()->json($address, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        $address->fill($request->validated())->save();
        return response()->json($address, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address): Response
    {
        $address->delete();
        return response()->noContent();
    }
}
