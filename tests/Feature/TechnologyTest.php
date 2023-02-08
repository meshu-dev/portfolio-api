<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TechnologyTest extends TestCase
{
    use RefreshDatabase;

    protected $url = '/api/technologies';

    protected $structure = [
        'id',
        'name'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->technologyService = $this->app->make('Tests\Services\TechnologyService');
    }

    public function test_getting_technology_by_id()
    {
        $this->setupAuth();

        $technology = $this->technologyService->addTechnology();

        $this->json('GET', "{$this->url}/{$technology->id}")
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->structure
            ]);
    }

    public function test_stop_getting_technology_by_id_with_no_token()
    {
        $technology = $this->technologyService->addTechnology();

        $this->testUnauthorised('GET', "{$this->url}/{$technology->id}");
    }

    public function test_getting_empty_technology_by_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('GET', "{$this->url}/$id")
             ->assertStatus(422);
    }

    public function test_getting_list_of_technologies()
    {
        $this->setupAuth();

        $this->technologyService->addTechnologies();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ]
            ]);
    }

    public function test_stop_getting_list_of_technologies_with_no_token()
    {
        $this->technologyService->addTechnologies();

        $this->testUnauthorised('GET', $this->url);
    }

    public function test_getting_empty_list_of_technologies()
    {
        $this->setupAuth();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJson([
                'data' => []
            ]);
    }

    public function test_adding_technology()
    {
        $this->setupAuth();

        $params = [
            'name' => 'Development'
        ];

        $this->json('POST', $this->url, $params)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure
            ])
            ->assertJson([
                'data' => [
                    'name' => 'Development'
                ]
            ]);
    }

    public function test_stop_adding_technology_with_no_token()
    {
        $params = [
            'name' => 'Development'
        ];

        $this->testUnauthorised('POST', $this->url, $params);
    }

    public function test_stop_adding_technology_with_duplicate_name()
    {
        $this->setupAuth();

        $this->technologyService->addTechnology();

        $params = [
            'name' => 'Development'
        ];

        $this->json('POST', $this->url, $params)
             ->assertStatus(422);
    }

    public function test_editing_technology()
    {
        $this->setupAuth();

        $technology = $this->technologyService->addTechnology();
        $id = $technology->id;

        $params = [
            'name' => 'Staging'
        ];

        $this->json('PUT', "{$this->url}/{$id}", $params)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $id,
                    'name' => 'Staging'
                ]
            ]);
    }

    public function test_stop_editing_technology_with_no_token()
    {
        $technology = $this->technologyService->addTechnology();

        $id = $technology->id;
        $params = [
            'name' => 'Staging'
        ];

        $this->testUnauthorised('PUT', "{$this->url}/{$id}", $params);
    }

    public function test_stop_editing_technology_with_duplicate_name()
    {
        $this->setupAuth();

        $technologies = $this->technologyService->addTechnologies();
        $id = $technologies[0]['id'];

        $params = [
            'name' => 'Staging'
        ];

        $this->json('PUT', "{$this->url}/{$id}", $params)
             ->assertStatus(422);
    }

    public function test_deleting_technology()
    {
        $this->setupAuth();

        $technology = $this->technologyService->addTechnology();
        $id = $technology->id;

        $this->json('DELETE', "{$this->url}/{$id}")
             ->assertNoContent();
    }

    public function test_stop_deleting_technology_with_no_token()
    {
        $technology = $this->technologyService->addTechnology();
        $id = $technology->id;

        $this->testUnauthorised('DELETE', "{$this->url}/{$id}");
    }

    public function test_stop_deleting_technology_with_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('DELETE', "{$this->url}/$id")
             ->assertStatus(422);
    }
}
