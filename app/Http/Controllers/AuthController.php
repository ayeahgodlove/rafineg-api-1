<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
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
        $data = $request->validated();
        $data['name'] = $data['lastName'] . '_' . $this->generateUserCode();
        $data['password'] =  Hash::make($data['password']);

        if (User::create($data)) {
            return response()->json([
                "success" => true,
                "message" => "You account has been successfully created",
                "data" => []
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "An error occured. Try again later",
                "data" => []
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
            "accessToken" => $user->createToken('user token')->plainTextToken,
            "data" => new UserResource($user)
        ]);
    }

    public function reset_password(string $email)
    {
        if (Auth::user()->email == $email) {
            // Send email with confirmation code

            // save code in password reset table


            // send response with confirmation code to be
            // saved on the state.
        }
    }

    /**
     * Handle phone and client email verifications
     * @param method
     */
    public function verify_client(string $method)
    {
        if ($method == 'email') {
            // handle email verification
        } else if ($method == 'phone') {
            // handle phone number verification
        } else {
            // throw verification error
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "success" => true,
            "message" => "Logout successful"
        ]);
    }

    private function generateUserCode(int $length = 6)
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length);
    }
}