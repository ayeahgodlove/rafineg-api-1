<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Signup new user in the app
     *
     * @param App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function signup(UserRequest $request)
    {
        // dd('hello singup');
        $data = $request->validated();
        $data['password'] =  Hash::make($data['password']);
        if (User::create($data)) {
            return response()->json([
                "status" => true,
                "message" => "You account has been successfully created"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "An error occured. Try again later"
            ]);
        }
    }

    /**
     * Login user into app
     *
     * @param App\Http\Requests\LoginUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function signin(LoginUserRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (!Auth::attempt($data)) {
            return response()->json([
                "success" => false,
                "message" => "Credentials do not match"
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Login successful",
            "accessToken" => $user->createToken('user token')->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "success" => true,
            "message" => "Logout successful"
        ]);
    }
}