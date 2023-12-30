<?php

namespace App\Services;

use App\Repositories\SubjectRepository;
use App\Models\Subject;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SubjectService
{
    private $repository;

    public function __construct(SubjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): Collection
    {
        return $this->repository->all();
    }

    public function show(int $id): ?Subject
    {
        return $this->repository->find($id, 'codAs');
    }

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

    public function destroy(int $id): ?Subject
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->find($id, 'codAs');

            if ($resource) {
                $this->repository->delete($id, 'codAs');

                DB::commit();

                return $resource;
            }
        } catch (Exception) {
            DB::rollBack();
        }

        return null;
    }
}
