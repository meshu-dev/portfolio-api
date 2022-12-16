<?php

namespace Tests\Services;

use App\Models\Project;

class ProjectService extends PortfolioService
{
    public function addProject()
    {
        return $this->createProject();
    }

    public function addProjects(): array
    {
        $projects = [
            $this->createProject(),
            $this->createProject()
        ];

        return $projects;
    }

    protected function createProject()
    {
        $data = $this->addRelatedData();
        $type = $data['type'];

        $project = Project::create([
            'type_id' => $type->id,
            'name' => 'CRUD Project',
            'description' => 'Test Job Title'
        ]);
        
        $this->attachRepositories($project, $data['repositories'] ?? []);
        $this->attachTechnologies($project, $data['technologies'] ?? []);
        $this->attachImages($project, $data['images'] ?? []);

        return $project;
    }
}
