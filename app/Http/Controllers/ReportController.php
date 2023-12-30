<?php

namespace App\Http\Controllers;

use App\Http\Resources\BooksByAuthorResource;
use App\Http\Resources\DefaultCollection;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    private ReportService $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function booksByAuthor(): JsonResponse
    {
        return $this->success(new DefaultCollection(BooksByAuthorResource::class, $this->service->booksByAuthor()));
    }
}
