<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function __construct(private AddressRepositoryInterface $repository) {

    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = $this->repository->getAll();
        return response()->json($addresses, Response::HTTP_OK);
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
    public function store(StoreAddressRequest $request)
    {
        $address = $this->repository->store($request->all());
        return response()->json($address, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        // é boa prática fazer consultas implícitas? (quando a model já vem como parâmetro)
        // passar como int e passar a id pro repository? qual a melhor forma de fazer?
        return response()->json($address, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Address $address)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->fill($request->all())->save();
        return response()->json($address, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return response()->noContent();
    }
}
