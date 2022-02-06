<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function sendMoney(Request $request)
    {
        $data = $request->validate([
            "amount" => "required|numeric",
            "receiver_id" => "required",
            "charge" => "numeric"
        ]);
    }

    public function withDraw(Request $request)
    {
    }
}