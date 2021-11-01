<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SavingResource;
use App\Models\Saving;
use  App\Http\Requests\CreateSavingRequest;
use Malico\MeSomb\Payment;


class SavingsController extends Controller
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
            "data" => SavingResource::collection(Saving::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSavingRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user()->id;
        $data['user'] = "$user";
        $tel = $data['telephone'];

        $transaction = new Payment("$tel", 30);

        $payment = $transaction->pay();

        if($payment->success) {
            //fire some event
            $saving = Saving::create($data);
            return response()->json([
                "success" => true,
                "data" => new SavingResource($saving),
                "message" => "Saving was added successfully"
            ]);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Saving failed",
                "data" => [],
            ]);
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Saving $saving)
    {
        return response()->json([
            "success" => true,
            "data" => new SavingResource($saving),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateSavingRequest $request, Saving $saving)
    {
        $data = $request->validated();
        if ($saving->update($data)) {
            return response()->json([
                "success" => true,
                "data" => new SavingResource($saving),
                "message" => "Saving has been updated successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new SavingResource($saving),
            "message" => "Error: Saving has not been updated!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Saving $saving)
    {
        if ($saving->delete()) {
            return response()->json([
                "success" => true,
                "data" => null,
                "message" => "Saving has been deleted successfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "data" => new SavingResource($saving),
            "message" => "An error occured. Saving could not be deleted"
        ]);
    }
}