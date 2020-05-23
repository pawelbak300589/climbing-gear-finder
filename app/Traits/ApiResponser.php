<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    /**
     * Success Response
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($data, $code = \Illuminate\Http\Response::HTTP_OK)
    {
        return response()->json($data, $code);
    }

    /**
     * Error Response
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * Error Message Response
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorMessage($message, $code)
    {
        return response()->json($message, $code);
    }
}
