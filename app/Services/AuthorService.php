<?php

namespace App\Services;

use App\Repositories\AuthorRepository;
use App\Models\Author;
use Throwable;
use App\Exceptions\AuthorException;
use Illuminate\Database\QueryException;
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

    public function show(int $id): Author
    {
        $author = $this->repository->find($id, 'CodAu');

        if (!$author) {
            throw AuthorException::notFound();
        }

        return $author;
    }

    public function store(array $data): Author
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
                $th instanceof QueryException => throw AuthorException::unableToSave(),
                default => throw $th,
            };
        }
    }

    public function update($id, $data): Author
    {
        $author = $this->show($id);

        DB::beginTransaction();

        try {
            $this->repository->update($data, $id, 'CodAu');
            
            DB::commit();

            return $author;
        } 
        catch (Throwable $th) {
            DB::rollBack();

            match (true) {
                $th instanceof QueryException => throw AuthorException::unableToSave(),
                default => throw $th,
            };
        }
    }

    public function destroy(int $id): Author
    {
        $author = $this->show($id);
        
        DB::beginTransaction();

        try {
            $author->books()->detach();
            $this->repository->delete($id, 'CodAu');

            DB::commit();

            return $author;
        } 
        catch (Throwable $th) {
            DB::rollBack();

            match (true) {
                $th instanceof QueryException => throw AuthorException::unableToSave(),
                default => throw $th,
            };
        }
    }
}
