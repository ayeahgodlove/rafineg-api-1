<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Malico\MeSomb\Payment;
use Malico\MeSomb\Deposit;

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
        $data['password'] =  Hash::make($data['password']);
        //registration fee transaction
        $request = new Deposit("".$data->phone_number."", 100);

        $payment = $request->pay();

        if($payment->success){
            // Fire some event, send payout email
            $data['registration_fee_paid'] = true;
        } else {
            // fire some event, redirect to error page
        }

        // get Transactions details $payment->transactions
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
            "accessToken" => $user->createToken('user token')->plainTextToken,
            "data" => new UserResource($user)
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