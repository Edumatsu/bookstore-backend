<?php

namespace App\Traits\Http;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ResponseTrait
{
    public function success(array|JsonResource $data): JsonResponse
    {
        return response()->json($data, Response::HTTP_OK);
    }

    public function noContent(): JsonResponse
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function created(array|JsonResource $data = []): JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }
}
