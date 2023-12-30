<?php

namespace App\Services;

use App\Repositories\SubjectRepository;
use App\Models\Subject;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class SubjectService
 *
 * @package App\Services
 */
class SubjectService
{
    private $repository;

    public function __construct(SubjectRepository $repository)
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
    public function show(int $id): ?Subject
    {
        return $this->repository->find($id, "codAs");
    }

    /**
     * @param  array $data
     * @return Collection
     */
    public function store(array $data): ?Subject
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
    public function update($id, $data): ?Subject
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->update($data, $id, 'codAs');
            
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
    public function destroy(int $id): ?Subject
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->find($id, "codAs");

            if ($resource) {
                $this->repository->delete($id, "codAs");

                DB::commit();

                return $resource;
            }
        } catch (Exception) {
            DB::rollBack();
        }

        return null;

    }
}
