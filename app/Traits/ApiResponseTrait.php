<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Send a JSON response with success message.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($code, $data = null, $message = 'Success')
    {
        return response()->json([
            'code' => $code,
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Send a JSON response with error message.
     *
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($code, $message = 'Error')
    {
        return response()->json([
            'code' => $code,
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
