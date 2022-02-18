<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegistrationFeeResource;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateRegistrationFeeRequest;
use App\Models\RegistrationFee;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Malico\MeSomb\Payment;

class RegistrationFeesController extends Controller
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
            "data" => RegistrationFeeResource::collection(RegistrationFee::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateRegistrationFeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRegistrationFeeRequest $request)
    {
        Log::debug("registration request " . $request);
        $data = $request->validated();
        //registration fee transaction
        $data['username'] = auth()->user()->name;
        $data['user_id'] = auth()->user()->id;
        $data['amount'] = "30";
        $tel = $data['phone_number'];

        $transaction = new Payment("$tel", $data['amount']);

        $deposit = $transaction->pay();
        $currentUser = User::find(auth()->user()->id);

        $registrationFee = null;
        if ($deposit->success) {
            // Fire some event, send payout email
            $registrationFee = RegistrationFee::create($data);
            $currentUser['is_registered'] = true;
            $currentUser->save();

            // update user cashbox


            return response()->json([
                "data" => [
                    "registrationFee" => new RegistrationFeeResource($registrationFee),
                    "user" => new UserResource($currentUser),
                ],
                "success" => true
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "payment failed",
            "data" => [],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RegistrationFee $registrationFee)
    {
        if ($registrationFee->exits()) {
            return response()->json([
                "success" => true,
                "data" => new RegistrationFeeResource($registrationFee),
                "message" => ""
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => null,
            "message" => "RegistrationFee does not exist."
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRegistrationFeeRequest $request, $id)
    {
        $registrationFee = RegistrationFee::find($id);
        if ($registrationFee->exits()) {
            $data = $request->validated();
            $registrationFee->update($data);
            return response()->json([
                "success" => true,
                "data" => new RegistrationFeeResource($registrationFee),
                "message" => "Registration fee has been updated successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => null,
            "message" => "RegistrationFee could not be updated"
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
        $registrationFee = RegistrationFee::find($id);
        if ($registrationFee->exits()) {
            if ($registrationFee->delete()) {
                return response()->json([
                    "success" => true,
                    "data" => null,
                    "message" => "RegistrationFee deleted successfully"
                ], 201);
            }
            return response()->json([
                "success" => false,
                "data" => null,
                "message" => "RegistrationFee could not be deleted"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => null,
            "message" => "RegistrationFee does not exist"
        ]);
    }
}
