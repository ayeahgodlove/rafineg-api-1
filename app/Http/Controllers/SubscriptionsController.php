<?php

namespace App\Http\Controllers;

use App\Models\Package;

class SubscriptionsController extends Controller
{
    public function subscribe($package_id)
    {
        $package = Package::find($package_id);
        // if($package)
        // {
        //     //
        //     return true;
        // }
    }
}