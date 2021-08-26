<?php

namespace App\Providers;

use Facade\FlareClient\Http\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Response::macro('success', function ($data =  null, $message = null) {
        //     return response()->json([
        //         'success' => true,
        //         'data' => $data,
        //         'message' => $message
        //     ]);
        // });

        // Response::macro('error', function ($data, $message, $error_code) {
        //     return response()->json([
        //         "data" => $data,
        //         "message" => $message,
        //         "success" => false
        //     ], $error_code);
        // });
    }
}