<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Models\User;

class SubscriptionsController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        return json_encode($user->subscriptions());
        return response()->json([
            'success' => true,
            'data' => $user->subscriptions
        ]);
    }


    public function subscribe($id)
    {
        $package = Package::find($id);
        auth()->user()->subscriptions()->attach($package->id);
        return response()->json([
            "success" => true,
            "message" => "You have subscribe to this package",
            "data" =>  new PackageResource($package)
        ]);
    }


    public function unsubscribe($id)
    {
        $package = Package::find($id);
        auth()->user()->subscriptions()->detach($package);

        return response()->json([
            "success" => true,
            "message" => "You have unscribed to this package",
            "data" => []
        ]);
    }
}