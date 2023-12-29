<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Build success response
     * @param  array $data
     * @return JsonResponse
     */
    public static function success($data): JsonResponse
    {
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Build creative response
     *
     * @param  array $data
     * @return JsonResponse
     */
    public static function create($data): JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Build no content response
     *
     * @return JsonResponse
     */
    public static function noContent(): JsonResponse
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
