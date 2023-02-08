<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected $url = '/api/projects';

    protected $structure = [
        'id',
        'type',
        'name',
        'repositories',
        'technologies',
        'images'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->projectService = $this->app->make('Tests\Services\ProjectService');
    }


    public function test_getting_project_by_id()
    {
        $this->setupAuth();

        $project = $this->projectService->addProject();

        $this->json('GET', "{$this->url}/{$project->id}")
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->structure
            ]);
    }

    public function test_stop_getting_project_by_id_with_no_token()
    {
        $project = $this->projectService->addProject();

        $this->testUnauthorised('GET', "{$this->url}/{$project->id}");
    }

    public function test_getting_empty_project_by_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('GET', "{$this->url}/$id")
             ->assertStatus(422);
    }

    public function test_getting_list_of_projects()
    {
        $this->setupAuth();

        $this->projectService->addProjects();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ]
            ]);
    }

    public function test_stop_getting_list_of_projects_with_no_token()
    {
        $this->projectService->addProjects();

        $this->testUnauthorised('GET', $this->url);
    }

    public function test_getting_empty_list_of_projects()
    {
        $this->setupAuth();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJson([
                'data' => []
            ]);
    }

    public function test_adding_project()
    {
        $this->setupAuth();

        $data = $this->projectService->addRelatedData();
        $type = $data['type'];
        $repositories = $data['repositories'];
        $technologies = $data['technologies'];
        $images = $data['images'];

        $params = [
            'name' => 'Test name',
            'description' => 'Test Job Title',
            'typeId' => $type->id,
            'repositoryIds' => $this->projectService->getRepositoryIds($repositories),
            'technologyIds' => $this->projectService->getTechnologyIds($technologies),
            'imageIds' => $this->projectService->getImageIds($images)
        ];

        $this->json('POST', $this->url, $params)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure
            ])
            ->assertJson([
                'data' => [
                    'name' => 'Test name',
                    'description' => 'Test Job Title'
                ]
            ]);
    }

    public function test_stop_adding_project_with_no_token()
    {
        $params = [
            'name' => 'Test name',
            'description' => 'Test Job Title'
        ];

        $this->testUnauthorised('POST', $this->url, $params);
    }

    public function test_stop_adding_project_with_duplicate_name()
    {
        $this->setupAuth();

        $this->projectService->addProject();

        $data = $this->projectService->addRelatedData();
        $type = $data['type'];
        $repositories = $data['repositories'];
        $technologies = $data['technologies'];
        $images = $data['images'];

        $params = [
            'name' => 'CRUD Project',
            'description' => 'Test Job Title',
            'typeId' => $type->id,
            'repositoryIds' => $this->projectService->getRepositoryIds($repositories),
            'technologyIds' => $this->projectService->getTechnologyIds($technologies),
            'imageIds' => $this->projectService->getImageIds($images)
        ];

        $this->json('POST', $this->url, $params)
             ->assertStatus(422);
    }

    public function test_editing_project()
    {
        $this->setupAuth();

        $project = $this->projectService->addProject();
        $id = $project->id;

        $data = $this->projectService->addRelatedData();
        $type = $data['type'];
        $repositories = $data['repositories'];
        $technologies = $data['technologies'];
        $images = $data['images'];

        $params = [
            'name' => 'Test name',
            'description' => 'Test Job Title',
            'typeId' => $type->id,
            'repositoryIds' => $this->projectService->getRepositoryIds($repositories),
            'technologyIds' => $this->projectService->getTechnologyIds($technologies),
            'imageIds' => $this->projectService->getImageIds($images)
        ];

        $this->json('PUT', "{$this->url}/{$id}", $params)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $id,
                    'name' => 'Test name',
                    'description' => 'Test Job Title'
                ]
            ]);
    }

    public function test_stop_editing_project_with_no_token()
    {
        $project = $this->projectService->addProject();

        $id = $project->id;

        $data = $this->projectService->addRelatedData();
        $type = $data['type'];
        $repositories = $data['repositories'];
        $technologies = $data['technologies'];
        $images = $data['images'];

        $params = [
            'name' => 'Test name',
            'description' => 'Test Job Title',
            'typeId' => $type->id,
            'repositoryIds' => $this->projectService->getRepositoryIds($repositories),
            'technologyIds' => $this->projectService->getTechnologyIds($technologies),
            'imageIds' => $this->projectService->getImageIds($images)
        ];

        $this->testUnauthorised('PUT', "{$this->url}/{$id}", $params);
    }

    public function test_stop_editing_project_with_duplicate_name()
    {
        $this->setupAuth();

        $projects = $this->projectService->addProjects();
        $firstProject = $projects[0];
        $secondProject = $projects[1];

        $id = $firstProject->id;

        $data = $this->projectService->addRelatedData();
        $type = $data['type'];
        $repositories = $data['repositories'];
        $technologies = $data['technologies'];
        $images = $data['images'];

        $params = [
            'name' => $secondProject->name,
            'description' => 'Test Job Title',
            'typeId' => $type->id,
            'repositoryIds' => $this->projectService->getRepositoryIds($repositories),
            'technologyIds' => $this->projectService->getTechnologyIds($technologies),
            'imageIds' => $this->projectService->getImageIds($images)
        ];

        $this->json('PUT', "{$this->url}/{$id}", $params)
             ->assertStatus(422);
    }

    public function test_deleting_project()
    {
        $this->setupAuth();

        $project = $this->projectService->addProject();
        $id = $project->id;

        $this->json('DELETE', "{$this->url}/{$id}")
             ->assertNoContent();
    }

    public function test_stop_deleting_project_with_no_token()
    {
        $project = $this->projectService->addProject();
        $id = $project->id;

        $this->testUnauthorised('DELETE', "{$this->url}/{$id}");
    }

    public function test_stop_deleting_project_with_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('DELETE', "{$this->url}/$id")
             ->assertStatus(422);
    }
}
