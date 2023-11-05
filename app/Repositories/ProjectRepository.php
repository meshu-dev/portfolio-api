<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends ModelRepository
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }
}
