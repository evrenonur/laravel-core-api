<?php

namespace App\Core;

/**
 *
 */
trait HttpResponse
{

    /**
     * @param $isSuccess
     * @param $message
     * @param $data
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function httpResponse($isSuccess = false, $message, $data = null, $statusCode)
    {
        if (!$message) return response()->json(['message' => 'Message is required'], 500);

        return response()->json([
            'message' => $message,
            'success' => $isSuccess,
            'status' => $statusCode,
            'data' => $data
        ], $statusCode);
    }
}
