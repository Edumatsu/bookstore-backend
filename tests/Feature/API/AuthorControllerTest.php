<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Author;
use App\Http\Requests\Adapters\AuthorRequestAdapter;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o endpoint de listagem de autores.
     */
    public function test_get_authors_endpoint(): void
    {
        Author::factory(1)->create();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(200);

        $response->assertJson(
            function (AssertableJson $json) {
                $json->whereAllType(
                    [
                        'data.0.id' => 'integer',
                        'data.0.name' => 'string',
                    ]
                )->etc();

                $json->hasAll(
                    [
                        'data.0.id',
                        'data.0.name',
                    ]
                )->etc();
            }
        );
    }

    /**
     * Testa o endpoint de detalhe do autor.
     */
    public function test_get_author_endpoint(): void
    {
        $author = Author::factory(1)->createOne();
        
        $response = $this->getJson('/api/authors/' . $author->Codl);

        $response->assertStatus(200);

        $response->assertJson(
            function (AssertableJson $json) {
                $json->whereAllType(
                    [
                        'id' => 'integer',
                        'name' => 'string',
                    ]
                );

                $json->hasAll(
                    [
                        'id',
                        'name',
                    ]
                )->etc();
            }
        );
    }

    /**
     * Testa o endpoint de criação do autor.
     */
    public function test_post_authors_endpoint(): void
    {
        $author = Author::factory(1)->makeOne()->toArray();
        $author = AuthorRequestAdapter::revert($author);

        $response = $this->postJson('/api/authors', $author);

        $response->assertStatus(201);

        $response->assertJson(
            function (AssertableJson $json) use ($author) {
                $json->whereAllType(
                    [
                        'id' => 'integer',
                        'name' => 'string',
                    ]
                );

                $json->hasAll(
                    [
                        'id',
                        'name',
                    ]
                );

                $json->whereAll(
                    [
                        'name' => $author['name'],
                    ]
                )->etc();
            }
        );
    }
}
