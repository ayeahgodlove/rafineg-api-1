<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RegistrationFeeResource;
use App\Http\Requests\CreateRegistrationFeeRequest;
use App\Models\RegistrationFee;
use Malico\MeSomb\Payment;
use Malico\MeSomb\Deposit;

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
        $data = $request->validated();
        //registration fee transaction
        $data['username'] = auth()->user()->name;
        $data['amount'] = "5000";
        $tel = $data['phone_number'];
        $transaction = new Payment("$tel", 30);

        $deposit = $transaction->pay();

        if($deposit->success){
            // Fire some event, send payout email
            $registrationFee = RegistrationFee::create($data);

        } 

        // get Transactions details $payment->transactions

        return response()->json([
            "data" => new RegistrationFeeResource(($registrationFee)),
            "success" => true
        ]);


        $package = RegistrationFee::create($data);

        return response()->json([
            "success" => true,
            "data" => new RegistrationFeeResource($package),
            "message" => "RegistrationFee was added successfully"
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