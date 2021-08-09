<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;

class UsersController extends Controller
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
            "data" => UserResource::collection(User::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        return response()->json([
            "success" => true,
            "data" => new UserResource($user),
            "message" => "User was added successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            "success" => true,
            "data" => new UserResource($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if ($user->update($data)) {
            return response()->json([
                "success" => true,
                "data" => new UserResource($user),
                "message" => "User has been updated successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new UserResource($user),
            "message" => "Error: user has not been updated!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->json([
                "success" => true,
                "data" => null,
                "message" => "User has been deleted successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new UserResource($user),
            "message" => "An error occured. User could not be deleted"
        ]);
    }
}