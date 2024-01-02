<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Subject;
use App\Http\Requests\Adapters\SubjectRequestAdapter;

class SubjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o endpoint de listagem de assuntos.
     */
    public function test_get_subjects_endpoint(): void
    {
        Subject::factory(1)->create();

        $response = $this->getJson('/api/subjects');

        $response->assertStatus(200);

        $response->assertJson(
            function (AssertableJson $json) {
                $json->whereAllType(
                    [
                        'data.0.id' => 'integer',
                        'data.0.description' => 'string',
                    ]
                )->etc();

                $json->hasAll(
                    [
                        'data.0.id',
                        'data.0.description',
                    ]
                )->etc();
            }
        );
    }

    /**
     * Testa o endpoint de detalhe do assunto.
     */
    public function test_get_subject_endpoint(): void
    {
        $subject = Subject::factory(1)->createOne();
        
        $response = $this->getJson('/api/subjects/' . $subject->Codl);

        $response->assertStatus(200);

        $response->assertJson(
            function (AssertableJson $json) {
                $json->whereAllType(
                    [
                        'id' => 'integer',
                        'description' => 'string',
                    ]
                );

                $json->hasAll(
                    [
                        'id',
                        'description',
                    ]
                )->etc();
            }
        );
    }

    /**
     * Testa o endpoint de criação do assunto.
     */
    public function test_post_subjects_endpoint(): void
    {
        $subject = Subject::factory(1)->makeOne()->toArray();
        $subject = SubjectRequestAdapter::revert($subject);

        $response = $this->postJson('/api/subjects', $subject);

        $response->assertStatus(201);

        $response->assertJson(
            function (AssertableJson $json) use ($subject) {
                $json->whereAllType(
                    [
                        'id' => 'integer',
                        'description' => 'string',
                    ]
                );

                $json->hasAll(
                    [
                        'id',
                        'description',
                    ]
                );

                $json->whereAll(
                    [
                        'description' => $subject['description'],
                    ]
                )->etc();
            }
        );
    }
}
