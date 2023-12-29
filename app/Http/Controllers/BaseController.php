<?php

namespace App\Http\Controllers;

use App\Http\Resources\v1\DefaultCollection;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use ApiResponse;
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Repository instance
     */
    protected $service;

    /**
     * Resource instance
     */
    protected $resource;

    public function index(): JsonResponse
    {
        $resources = $this->service->all();

        return ApiResponse::success(new DefaultCollection($this->resource, $resources));
    }

    public function show(int $id): JsonResponse
    {
        $resource = $this->service->find($id);

        return ApiResponse::success(new $this->resource($resource));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->findAndDelete($id);

        return ApiResponse::noContent();
    }
}
