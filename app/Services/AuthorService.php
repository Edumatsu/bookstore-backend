<?php

namespace App\Services;

use App\Repositories\AuthorRepository;
use App\Models\Author;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class AuthorService
 *
 * @package App\Services
 */
class AuthorService
{
    private $repository;

    public function __construct(AuthorRepository $repository)
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
     * @param  integer $id
     * @return Collection
     */
    public function show(int $id): ?Author
    {
        return $this->repository->find($id, "CodAu");
    }

    /**
     * @param  array $data
     * @return Collection
     */
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

    /**
     * @param  int   $id
     * @param  array $data
     * @return Collection
     */
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

    /**
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): ?Author
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->find($id, "CodAu");

            if ($resource) {
                $resource->books()->detach();
                $this->repository->delete($id, "CodAu");

                DB::commit();

                return $resource;
            }
        } catch (Exception) {
            DB::rollBack();
        }

        return null;

    }
}
