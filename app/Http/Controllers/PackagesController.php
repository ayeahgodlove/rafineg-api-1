<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\PackageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        $data = $request->validated();
        Package::create($data);
        return response()->json([
            "success" => true,
            "data" => new PackageResource($data),
            "message" => "New package has been added"
        ]);
        // return response()->json([
        //     "success" => false,
        //     "data" => null,
        //     "message" => "Package could not be created."
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        if ($package->exits()) {
            return response()->json([
                "success" => true,
                "data" => new PackageResource($package),
                "message" => ""
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => null,
            "message" => "Package does not exist."
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PackageRequest $request, $id)
    {
        $package = Package::find($id);
        if ($package->exits()) {
            $data = $request->validated();
            $package->update($data);
            return response()->json([
                "success" => true,
                "data" => new PackageResource($package),
                "message" => "Package has been updated successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => null,
            "message" => "Package could not be updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::find($id);
        if ($package->exits()) {
            if ($package->delete()) {
                return response()->json([
                    "success" => true,
                    "data" => null,
                    "message" => "Package deleted successfully"
                ], 201);
            }
            return response()->json([
                "success" => false,
                "data" => null,
                "message" => "Package could not be deleted"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => null,
            "message" => "Package does not exist"
        ]);
    }
}