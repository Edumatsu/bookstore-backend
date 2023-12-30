<?php

namespace App\Services;

use App\Repositories\AuthorRepository;
use App\Models\Author;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AuthorService
{
    private $repository;

    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): Collection
    {
        return $this->repository->all();
    }

    public function show(int $id): ?Author
    {
        return $this->repository->find($id, 'CodAu');
    }

    public function store(array $data): ?Author
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->create($data);

            DB::commit();

            return $resource;
        } catch (Exception) {
            DB::rollBack();
        }

        return null;
    }

    public function update($id, $data): ?Author
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->update($data, $id, 'CodAu');
            
            DB::commit();

            return $resource;
        } catch (Exception) {
            DB::rollBack();
        }

        return null;
    }

    public function destroy(int $id): ?Author
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->find($id, 'CodAu');

            if ($resource) {
                $resource->books()->detach();
                $this->repository->delete($id, 'CodAu');

                DB::commit();

                return $resource;
            }
        } catch (Exception) {
            DB::rollBack();
        }

        return null;

    }
}
