<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class SubscriptionsController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => auth()->user()->subscriptions
        ]);
    }


    public function subscribe($id)
    {
        try {
            $package = Package::find($id);
            auth()->user()->subscriptions()->attach($package->id);
            return response()->json([
                "success" => true,
                "message" => "You have subscribe to this package",
                "data" =>  new PackageResource($package)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
                "data" =>  null
            ]);
        }
    }


    public function unsubscribe($id)
    {
        try {
            $package = Package::find($id);
            auth()->user()->subscriptions()->detach($package);

            return response()->json([
                "success" => true,
                "message" => "You have unscribed to this package",
                "data" => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
                "data" =>  null
            ]);
        }
    }
}