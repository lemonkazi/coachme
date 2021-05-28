<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data, $message, $status = Response::HTTP_OK) {
            $response = [
                'success'  => true,
                'message' => $message,
            ];

            if ($data instanceof LengthAwarePaginator) {
                $dataArrray = $data->toArray();
                $response = array_merge($response, $dataArrray);
            } elseif ($data !== false) {
                if (is_array($data) && array_key_exists('data', $data)) {
                    $response = array_merge($response, $data);
                } else {
                    $response['data'] = $data;
                }
            }

            return Response::json($response, $status);
        });
    
        Response::macro('error', function ($message, $status = Response::HTTP_BAD_REQUEST) {
            return Response::json([
              'success'  => false,
              'message' => $message,
            ], $status);
        });
    }
}
