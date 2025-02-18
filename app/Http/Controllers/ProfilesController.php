<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "success"   => true,
            "data"      => ProfileResource::collection(Profile::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileRequest $request)
    {
        $data = $request->validated();

        if (request()->hasFile('image')) {
            $path = request()->file('image')->move('images');
            $data['image'] = asset($path);
        }

        $profile = Profile::create($data);

        return response()->json([
            "success"   => true,
            "data"      => new ProfileResource($profile),
            "message"   => "Profile has been created successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        if ($profile) {
            return response()->json([
                "success"   => true,
                "data"      => new ProfileResource($profile)
            ]);
        }
        return response()->json([
            "success"   => false,
            "message"   => "Profile not found."
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        $data = $request->validated();
        if (request()->hasFile('image')) {
            Storage::delete($profile->image);
            $path = request()->file('image')->move('images');
            $data['image'] = asset($path);
        }
        $profile = $profile->update($data);
        return response()->json([
            "success"   => true,
            "data"      => new ProfileResource($profile),
            "message"   => "Profile has been updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response()->json([
            "success"   => true,
            "data"      => null,
            "message"   => "Profile information has been deleted successfully"
        ], 201);
    }
}
