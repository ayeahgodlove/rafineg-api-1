<?php

namespace App\Http\Controllers;

use App\Models\CashTransfer;
use App\Http\Requests\StoreCashTransferRequest;
use App\Http\Requests\UpdateCashTransferRequest;
use App\Http\Resources\CashTransferResource;
use App\Models\User;

class CashTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return all current cash transfer to user
        return response()->json([
            "success" => true,
            "message" => "",
            "data" => CashTransferResource::collection(CashTransfer::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCashTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashTransferRequest $request)
    {
        $data = $request->validated();

        // update cashbox sender cashbox
        $sender = User::find($data['sender']);

        if ($sender->cashbox()->balance > $data['amount']) {
            $sender->cashbox()->balance -= $data['amount'];
            $sender->cashbox()->save();

            // get receiver cashbox
            $receiver = User::find($data['receiver']);
            $receiver->cashbox()->balance = $data['amount'];
            $receiver->cashobx()->save();

            // Send feedback
            CashTransfer::create($data);
            return response()->json([
                "success" => true,
                "message" => "Sending money completed successfully",
                "data" => new CashTransferResource($data)
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "You have less than that amount in your wallet",
            "data" => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CashTransfer  $cashTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(CashTransfer $cashTransfer)
    {
        return response()->json([
            "success" => true,
            "message" => '',
            "data" => new CashTransferResource($cashTransfer)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CashTransfer  $cashTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(CashTransfer $cashTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCashTransferRequest  $request
     * @param  \App\Models\CashTransfer  $cashTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCashTransferRequest $request, CashTransfer $cashTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CashTransfer  $cashTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashTransfer $cashTransfer)
    {
        $cashTransfer->delete();
        return response()->json([
            "success" => true,
            "message" => 'Cash transfer record deleted successfully',
            "data" => null
        ]);
    }
}