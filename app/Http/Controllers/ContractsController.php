<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Contract;

class ContractsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "success" => true,
            "data" => ContractResource::collection(Contract::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateContractRequest $request)
    {
        $data = $request->validated();
        $contract = Contract::create($data);
        return response()->json([
            "success" => true,
            "data" => new ContractResource($contract),
            "message" => "Contract was added successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        return response()->json([
            "success" => true,
            "data" => new ContractResource($contract),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $data = $request->validated();
        if ($contract->update($data)) {
            return response()->json([
                "success" => true,
                "data" => new ContractResource($contract),
                "message" => "Contract has been updated successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new ContractResource($contract),
            "message" => "Error: Contract has not been updated!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        if ($contract->delete()) {
            return response()->json([
                "success" => true,
                "data" => null,
                "message" => "Contract has been deleted successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new ContractResource($contract),
            "message" => "An error occured. Contract could not be deleted"
        ]);
    }
}