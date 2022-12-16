<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $url = '/api/repositories';

    protected $structure = [
        'id',
        'name',
        'url'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->repositoryService = $this->app->make('Tests\Services\RepositoryService');
    }

    public function test_getting_repository_by_id()
    {
        $this->setupAuth();

        $repository = $this->repositoryService->addRepository();

        $this->json('GET', "{$this->url}/{$repository->id}")
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->structure
            ]);
    }

    public function test_stop_getting_repository_by_id_with_no_token()
    {
        $repository = $this->repositoryService->addRepository();

        $this->testUnauthorised('GET', "{$this->url}/{$repository->id}");
    }

    public function test_getting_empty_repository_by_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('GET', "{$this->url}/$id")
             ->assertStatus(422);
    }

    public function test_getting_list_of_repositories()
    {
        $this->setupAuth();

        $this->repositoryService->addRepositories();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ]
            ]);
    }

    public function test_stop_getting_list_of_repositories_with_no_token()
    {
        $this->repositoryService->addRepositories();

        $this->testUnauthorised('GET', $this->url);
    }

    public function test_getting_empty_list_of_repositories()
    {
        $this->setupAuth();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJson([
                'data' => []
            ]);
    }

    public function test_adding_repository()
    {
        $this->setupAuth();

        $params = [
            'name' => 'Development',
            'url' => 'http://devbranch.com'
        ];

        $this->json('POST', $this->url, $params)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure
            ])
            ->assertJson([
                'data' => [
                    'name' => 'Development',
                    'url' => 'http://devbranch.com'
                ]
            ]);
    }

    public function test_stop_adding_repository_with_no_token()
    {
        $params = [
            'name' => 'Development',
            'url' => 'http://devbranch.com'
        ];

        $this->testUnauthorised('POST', $this->url, $params);
    }

    public function test_stop_adding_repository_with_duplicate_name()
    {
        $this->setupAuth();

        $this->repositoryService->addRepository();

        $params = [
            'name' => 'Development',
            'url' => 'http://devbranch.com'
        ];

        $this->json('POST', $this->url, $params)
             ->assertStatus(422);
    }

    public function test_editing_repository()
    {
        $this->setupAuth();

        $repository = $this->repositoryService->addRepository();
        $id = $repository->id;

        $params = [
            'name' => 'Staging',
            'url' => 'http://staggggbranch.com'
        ];

        $this->json('PUT', "{$this->url}/{$id}", $params)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $id,
                    'name' => 'Staging',
                    'url' => 'http://staggggbranch.com'
                ]
            ]);
    }

    public function test_stop_editing_repository_with_no_token()
    {
        $repository = $this->repositoryService->addRepository();

        $id = $repository->id;
        $params = [
            'name' => 'Staging',
            'url' => 'http://stagbranch.com'
        ];

        $this->testUnauthorised('PUT', "{$this->url}/{$id}", $params);
    }

    public function test_stop_editing_repository_with_duplicate_name()
    {
        $this->setupAuth();

        $repositories = $this->repositoryService->addRepositories();
        $id = $repositories[0]['id'];

        $params = [
            'name' => 'Staging',
            'url' => 'http://stagbranch.com'
        ];

        $this->json('PUT', "{$this->url}/{$id}", $params)
             ->assertStatus(422);
    } 

    public function test_deleting_repository()
    {
        $this->setupAuth();

        $repository = $this->repositoryService->addRepository();
        $id = $repository->id;

        $this->json('DELETE', "{$this->url}/{$id}")
             ->assertNoContent();
    }

    public function test_stop_deleting_repository_with_no_token()
    {
        $repository = $this->repositoryService->addRepository();
        $id = $repository->id;

        $this->testUnauthorised('DELETE', "{$this->url}/{$id}");
    }

    public function test_stop_deleting_repository_with_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('DELETE', "{$this->url}/$id")
             ->assertStatus(422);
    }
}
