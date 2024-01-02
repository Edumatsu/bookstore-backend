<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;
use App\Http\Requests\Adapters\BookRequestAdapter;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o endpoint de listagem de livros.
     */
    public function test_get_books_endpoint(): void
    {
        Book::factory(1)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);

        $response->assertJson(
            function (AssertableJson $json) {
                $json->whereAllType(
                    [
                        'data.0.id' => 'integer',
                        'data.0.title' => 'string',
                        'data.0.publishingCompany' => 'string',
                        'data.0.authors' => 'array',
                    ]
                )->etc();

                $json->hasAll(
                    [
                        'data.0.id',
                        'data.0.title',
                        'data.0.publishingCompany',
                        'data.0.authors',
                    ]
                )->etc();
            }
        );
    }

    /**
     * Testa o endpoint de detalhe do livro.
     */
    public function test_get_book_endpoint(): void
    {
        $book = Book::factory(1)->createOne();
        
        $response = $this->getJson('/api/books/' . $book->Codl);

        $response->assertStatus(200);

        $response->assertJson(
            function (AssertableJson $json) {
                $json->whereAllType(
                    [
                        'id' => 'integer',
                        'title' => 'string',
                        'publishingCompany' => 'string',
                        'authors' => 'array',
                    ]
                );

                $json->hasAll(
                    [
                        'id',
                        'title',
                        'publishingCompany',
                        'authors',
                    ]
                )->etc();
            }
        );
    }

    /**
     * Testa o endpoint de criação do livro.
     */
    public function test_post_books_endpoint(): void
    {
        $book = Book::factory(1)->makeOne()->toArray();
        
        $author = Author::factory(1)->createOne();
        $book['Autores'] = [
            [
                "id" => $author->CodAu
            ]
        ];

        $subject = Subject::factory(1)->createOne();
        $book['Assuntos'] = [
            [
                "id" => $subject->codAs
            ]
        ];

        $book = BookRequestAdapter::revert($book);

        $response = $this->postJson('/api/books', $book);

        $response->assertStatus(201);

        $response->assertJson(
            function (AssertableJson $json) use ($book) {
                $json->whereAllType(
                    [
                        'id' => 'integer',
                        'title' => 'string',
                        'publishingCompany' => 'string',
                        'authors' => 'array',
                        'subjects' => 'array',
                    ]
                );

                $json->hasAll(
                    [
                        'id',
                        'title',
                        'publishingCompany',
                        'authors',
                        'subjects',
                    ]
                );

                $json->whereAll(
                    [
                        'title' => $book['title'],
                        'publishingCompany' => $book['publishingCompany']
                    ]
                )->etc();
            }
        );
    }
}
