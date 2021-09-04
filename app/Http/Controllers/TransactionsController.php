<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Malico\MeSomb\Deposit;

class TransactionsController extends Controller
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
            "data" => TransactionResource::collection(Transaction::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $method =  [
                    'momo' => 'MOMO',
                    'stripe' => 'STRIPE',
                ];
        //select transaction method
        //momo, stripe(card payment).

        $data = $request->validated();
        
        $transaction = Transaction::create($data);
        return response()->json([
            "success" => true,
            "data" => new TransactionResource($transaction),
            "message" => "Transaction was added successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return response()->json([
            "success" => true,
            "data" => new TransactionResource($transaction),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $data = $request->validated();
        if ($transaction->update($data)) {
            return response()->json([
                "success" => true,
                "data" => new TransactionResource($transaction),
                "message" => "Transaction has been updated successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new TransactionResource($transaction),
            "message" => "Error: Transaction has not been updated!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->delete()) {
            return response()->json([
                "success" => true,
                "data" => null,
                "message" => "Transaction has been deleted successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new TransactionResource($transaction),
            "message" => "An error occured. Contract could not be deleted"
        ]);
    }
}