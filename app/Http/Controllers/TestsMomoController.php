<?php

namespace App\Http\Controllers;

use Malico\MeSomb\Payment;

class TestsMomoController extends Controller
{
    public function confirmOrder()
    {
        $request = new Payment('237672374414', 100);

        $payment = $request->pay();

        dd($payment);

        if ($payment->success) {
            echo ("Successfull payment");
        } else {
            // fire some event, redirect to error page
            echo ("some unexpected occured");
        }

        // get Transactions details $payment->transactions
    }
}