<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageResource;
use App\Models\Package;

class SubscriptionsController extends Controller
{
	public function subscribe( $id)
	{
		$package = Package::find($id);
		auth()->user()->subscriptions()->attach($package->id);
		return response()->json([
			"success" => true,
			"data" =>  new PackageResource($package)
		]);
	}

	public function unsubscribe($id)
	{
		$package = Package::find($id);
		auth()->user()->subscriptions()->detach($package);

		return response()->json([
			"success" => true,
			"data" => []
		]);
	}
	public function subscriptions()
	{
		return response()->json([
			'success' => true,
			'data' => auth()->user()->subscriptions()
		])
	}

}
