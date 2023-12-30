<?php

namespace App\Services;

use App\Repositories\ViewBooksByAuthorRepository;
use Illuminate\Database\Eloquent\Collection;

class ReportService
{
    private $repository;

    public function __construct(ViewBooksByAuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function booksByAuthor(): Collection
    {
        return $this->repository->all();
    }
}
