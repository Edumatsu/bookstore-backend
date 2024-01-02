<?php

namespace App\Services;

use App\Repositories\SubjectRepository;
use App\Models\Subject;
use Throwable;
use App\Exceptions\SubjectException;
use Illuminate\Database\QueryException;
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

    public function show(int $id): Subject
    {
        $subject = $this->repository->find($id, 'codAs');

        if (!$subject) {
            throw SubjectException::notFound();
        }

        return $subject;
    }

    public function store(array $data): Subject
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->create($data);

            DB::commit();

            return $resource;
        } 
        catch (Throwable $th) {
            DB::rollBack();

            match (true) {
                $th instanceof QueryException => throw SubjectException::unableToSave(),
                default => throw $th,
            };
        }
    }

    public function update($id, $data): Subject
    {
        $subject = $this->show($id);

        DB::beginTransaction();

        try {
            $this->repository->update($data, $id, 'codAs');
            
            DB::commit();

            return $subject;
        } 
        catch (Throwable $th) {
            DB::rollBack();

            match (true) {
                $th instanceof QueryException => throw SubjectException::unableToSave(),
                default => throw $th,
            };
        }
    }

    public function destroy(int $id): Subject
    {
        $subject = $this->show($id);

        DB::beginTransaction();

        try {
            $this->repository->delete($id, 'codAs');

            DB::commit();

            return $subject;
        } 
        catch (Throwable $th) {
            DB::rollBack();

            match (true) {
                $th instanceof QueryException => throw SubjectException::unableToSave(),
                default => throw $th,
            };
        }
    }
}
