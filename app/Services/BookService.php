<?php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Repositories\AuthorRepository;
use App\Repositories\SubjectRepository;
use App\Models\Book;
use Throwable;
use App\Exceptions\BookException;
use App\Exceptions\AuthorException;
use App\Exceptions\SubjectException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BookService
{
    private $repository;

    private $authorRepository;

    private $subjectRepository;

    public function __construct(
        BookRepository $repository,
        AuthorRepository $authorRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->repository = $repository;
        $this->authorRepository = $authorRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function index(): Collection
    {
        return $this->repository->all();
    }

    public function show(int $id): ?Book
    {
        $book = $this->repository->find($id, 'Codl');

        if (!$book) {
            throw BookException::notFound();
        }

        return $book;
    }

    public function store(array $data): Book
    {
        $this->checkExistsRelationships($data);

        DB::beginTransaction();

        try {
            $resource = $this->repository->create($data);

            $ids = array_column($data['Autores'], 'id');
            $resource->authors()->attach($ids);

            $ids = array_column($data['Assuntos'], 'id');
            $resource->subjects()->attach($ids);

            DB::commit();

            return $resource;
        } 
        catch (Throwable $th) {
            DB::rollBack();

            match (true) {
                $th instanceof QueryException => throw BookException::unableToSave(),
                default => throw $th,
            };
        }
    }

    public function update($id, $data): Book
    {
        $this->checkExistsRelationships($data);

        $book = $this->repository->find($id, 'Codl');

        if (!$book) {
            throw BookException::notFound();
        }

        DB::beginTransaction();

        try {
            $ids = array_column($data['Autores'], 'id');
            $book->authors()->sync($ids);

            $ids = array_column($data['Assuntos'], 'id');
            $book->subjects()->sync($ids);

            unset($data['Autores'], $data['Assuntos']);

            $this->repository->update($data, $id, 'Codl');
            
            DB::commit();

            return $book;
        } 
        catch (Throwable $th) {
            DB::rollBack();

            match (true) {
                $th instanceof QueryException => throw BookException::unableToSave(),
                default => throw $th,
            };
        }
    }

    public function destroy(int $id): Book
    {
        $book = $this->repository->find($id, 'Codl');

        if (!$book) {
            throw BookException::notFound();
        }

        DB::beginTransaction();

        try {
            $book->authors()->detach();
            $book->subjects()->detach();

            $this->repository->delete($id, 'Codl');

            DB::commit();

            return $book;
        } 
        catch (Throwable $th) {
            DB::rollBack();

            match (true) {
                $th instanceof QueryException => throw BookException::unableToSave(),
                default => throw $th,
            };
        }
    }

    private function checkExistsRelationships(array $data): void
    {
        $this->checkExistsAuthors($data['Autores']);
        $this->checkExistsSubjects($data['Assuntos']);
    }

    private function checkExistsAuthors(array $authors): void
    {
        foreach ($authors as $author) {
            if (!$this->authorRepository->find($author['id'], 'CodAu')) {
                throw AuthorException::notFound();
            }
        }
    }

    private function checkExistsSubjects(array $subjects): void
    {
        foreach ($subjects as $subject) {
            if (!$this->subjectRepository->find($subject['id'], 'codAs')) {
                throw SubjectException::notFound();
            }
        }
    }
}
