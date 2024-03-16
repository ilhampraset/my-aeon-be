<?php

namespace App\Providers;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;


class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $response = app(ResponseFactory::class);

        $response->macro('success', function ($code, $data = null, $message='Success Retrieve Data' ) use ($response) {
            $responseData = collect([
                'code' => $code,
                'message' => $message,
            ]);

            return $response->json($responseData->merge($data), $code);
        });

        $response->macro('error', function ($code,$message, $errors) use ($response) {

            if (is_string($errors)) {
                return $response->json([
                    'code' => $code,
                    'message' => $message,
                    'errors' => [$errors],
                ], $code);
            }

            $flatten = [];
            array_walk_recursive($errors, function ($error) use (&$flatten) {
                $flatten[] = $error;
            });

            return $response->json([
                'code' => $code,
                'message' => $message,
                'errors' => $flatten,
            ], $code);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
