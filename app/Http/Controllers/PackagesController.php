<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Requests\CreatePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Resources\PackageResource;

class PackagesController extends Controller
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
            "data" => PackageResource::collection(Package::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePackageRequest $request)
    {
        $data = $request->validated();
        $contract = Package::create($data);
        return response()->json([
            "success" => true,
            "data" => new PackageResource($contract),
            "message" => "Package was added successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        return response()->json([
            "success" => true,
            "data" => new PackageResource($package),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $data = $request->validated();
        if ($package->update($data)) {
            return response()->json([
                "success" => true,
                "data" => new PackageResource($package),
                "message" => "Package has been updated successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new PackageResource($package),
            "message" => "Error: Package has not been updated!"
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        if ($package->delete()) {
            return response()->json([
                "success" => true,
                "data" => null,
                "message" => "Package has been deleted successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new PackageResource($package),
            "message" => "An error occured. Package could not be deleted"
        ]);
    }
}