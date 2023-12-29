<?php

namespace App\Services;

use App\Repositories\BookRepository;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\TestRunner\TestResult\Collector;

/**
 * Class BookService
 * @package App\Services
 */
class BookService
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->repository->all();
    }

    /**
     * @param integer $id
     * @return Collection
     */
    public function show(int $id): ?Collection
    {
        return $this->repository->find($id, "Codl");
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function store(array $data): Collection
    {
        $resource = $this->repository->create($data);
        $resource->autores()->attach($data['Autores']);

        return $resource;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Collection
     */
    public function update($id, $data): Collection
    {
        $resource = $this->repository->find($id, "Codl");

        $resource->autores()->sync($data['Autores']);

        return $this->repository->update($data, $id, 'Codl');
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): Collection
    {
        $resource = $this->repository->find($id, "Codl");
        $resource->autores()->detach();

        return $this->repository->delete($id, "Codl");
    }
}
